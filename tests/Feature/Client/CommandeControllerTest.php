<?php

namespace Tests\Feature\Client;

use App\Http\Controllers\Client\CommandeController;
use App\Models\Categorie;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class CommandeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_creates_an_order_and_decrements_stock_for_a_valid_cart(): void
    {
        $this->registerControllerRoutes();
        $user = User::factory()->create();
        $client = Client::create(['user_id' => $user->getKey()]);
        $produit = $this->createProduit(stock: 3);

        $response = $this->actingAs($user)
            ->withSession(['panier' => [$produit->getKey() => 2]])
            ->post('/_test/client/commandes', [
                'adresse_livraison' => '1 rue du Test',
                'telephone_livraison' => '0102030405',
            ]);

        $commande = Commande::query()->sole();

        $response->assertRedirect();
        $this->assertSame(
            url('/_test/client/commandes/'.$commande->getKey()),
            $response->headers->get('Location'),
        );
        $response->assertSessionMissing('panier');
        $this->assertSame($client->getKey(), $commande->client_id);
        $this->assertSame('20.00', $commande->montant_total);
        $this->assertDatabaseHas('ligne_commandes', [
            'commande_id' => $commande->getKey(),
            'produit_id' => $produit->getKey(),
            'quantite' => 2,
            'prix_unitaire' => '10.00',
            'sous_total' => '20.00',
        ]);
        $this->assertDatabaseHas('produits', [
            'id' => $produit->getKey(),
            'stock' => 1,
            'statut' => 'disponible',
        ]);
    }

    public function test_checkout_rejects_insufficient_stock_and_keeps_the_cart(): void
    {
        $this->registerControllerRoutes();
        $user = User::factory()->create();
        Client::create(['user_id' => $user->getKey()]);
        $produit = $this->createProduit(stock: 1);

        $response = $this->actingAs($user)
            ->withSession(['panier' => [$produit->getKey() => 2]])
            ->post('/_test/client/commandes', [
                'adresse_livraison' => '1 rue du Test',
                'telephone_livraison' => '0102030405',
            ]);

        $response->assertSessionHasErrors('panier')
            ->assertSessionHas('panier', [$produit->getKey() => 2]);
        $this->assertDatabaseCount('commandes', 0);
        $this->assertDatabaseHas('produits', [
            'id' => $produit->getKey(),
            'stock' => 1,
            'statut' => 'disponible',
        ]);
    }

    public function test_client_cannot_view_an_order_owned_by_another_client(): void
    {
        $this->registerControllerRoutes();
        $owner = User::factory()->create();
        $client = Client::create(['user_id' => $owner->getKey()]);
        $commande = $client->commandes()->create([
            'numero_commande' => 'CMD-ISOLATION-001',
            'adresse_livraison' => '1 rue du Test',
            'telephone_livraison' => '0102030405',
        ]);
        $otherUser = User::factory()->create();

        $this->actingAs($otherUser)
            ->get('/_test/client/commandes/'.$commande->getKey())
            ->assertNotFound();
    }

    private function registerControllerRoutes(): void
    {
        Route::post('/_test/client/commandes', [CommandeController::class, 'store'])
            ->middleware('web');
        Route::get('/_test/client/commandes/{commande}', [CommandeController::class, 'show'])
            ->middleware('web')
            ->name('client.commandes.show');
        Route::getRoutes()->refreshNameLookups();
    }

    private function createProduit(int $stock): Produit
    {
        $categorie = Categorie::create([
            'nom' => 'Soins',
            'slug' => 'soins',
        ]);

        return Produit::create([
            'categorie_id' => $categorie->getKey(),
            'nom' => 'Huile naturelle',
            'slug' => 'huile-naturelle',
            'prix' => 10,
            'stock' => $stock,
            'statut' => 'disponible',
        ]);
    }
}
