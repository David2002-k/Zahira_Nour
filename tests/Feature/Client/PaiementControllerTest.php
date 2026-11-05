<?php

namespace Tests\Feature\Client;

use App\Http\Controllers\Client\PaiementController;
use App\Models\Admin;
use App\Models\Categorie;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Ligne_commande;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PaiementControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_download_a_pdf_receipt_after_payment_is_confirmed(): void
    {
        $this->registerControllerRoutes();
        $user = User::factory()->create([
            'nom' => 'Client <script>',
            'prenom' => 'Test',
        ]);
        $commande = $this->createCommande($user);
        $paiement = $this->createPaiement($commande, 'confirme');

        $response = $this->actingAs($user)
            ->get('/_test/client/paiements/'.$paiement->getKey().'/recu');

        $response->assertDownload('recu-cmd-recu-001.pdf');
        $this->assertSame('application/pdf', $response->headers->get('content-type'));
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }

    public function test_client_cannot_download_a_receipt_before_payment_is_confirmed(): void
    {
        $this->registerControllerRoutes();
        $user = User::factory()->create();
        $commande = $this->createCommande($user);
        $paiement = $this->createPaiement($commande, 'en_attente');

        $this->actingAs($user)
            ->get('/_test/client/paiements/'.$paiement->getKey().'/recu')
            ->assertNotFound();
    }

    public function test_client_cannot_download_another_clients_receipt(): void
    {
        $this->registerControllerRoutes();
        $owner = User::factory()->create();
        $commande = $this->createCommande($owner);
        $paiement = $this->createPaiement($commande, 'confirme');
        $otherClient = User::factory()->create();

        $this->actingAs($otherClient)
            ->get('/_test/client/paiements/'.$paiement->getKey().'/recu')
            ->assertNotFound();
    }

    private function registerControllerRoutes(): void
    {
        Route::get('/_test/client/paiements/{paiement}/recu', [PaiementController::class, 'download'])
            ->middleware('web');
        Route::getRoutes()->refreshNameLookups();
    }

    private function createCommande(User $user): Commande
    {
        $client = Client::create(['user_id' => $user->getKey()]);
        $commande = $client->commandes()->create([
            'numero_commande' => 'CMD-RECU-001',
            'montant_total' => '75.50',
            'adresse_livraison' => '1 rue du Test',
            'telephone_livraison' => '0102030405',
        ]);
        $categorie = Categorie::create([
            'nom' => 'Soins',
            'slug' => 'soins',
        ]);
        $produit = Produit::create([
            'categorie_id' => $categorie->getKey(),
            'nom' => 'Huile naturelle',
            'slug' => 'huile-naturelle',
            'prix' => '75.50',
            'stock' => 3,
        ]);

        Ligne_commande::create([
            'commande_id' => $commande->getKey(),
            'produit_id' => $produit->getKey(),
            'quantite' => 1,
            'prix_unitaire' => '75.50',
            'sous_total' => '75.50',
        ]);

        return $commande;
    }

    private function createPaiement(Commande $commande, string $statut): Paiement
    {
        $admin = Admin::create([
            'user_id' => User::factory()->create(['role' => 'admin'])->getKey(),
        ]);

        return $commande->paiements()->create([
            'admin_id' => $admin->getKey(),
            'reference_paiement' => 'PAY-RECU-001',
            'montant_paye' => $commande->montant_total,
            'mode_paiement' => 'especes',
            'date_paiement' => now(),
            'statut' => $statut,
        ]);
    }
}
