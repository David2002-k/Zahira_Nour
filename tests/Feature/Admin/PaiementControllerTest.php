<?php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Admin\PaiementController;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PaiementControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_confirms_payment_at_delivery_for_the_full_order_amount(): void
    {
        $this->registerControllerRoutes();
        $user = User::factory()->create(['role' => 'admin']);
        $admin = Admin::create(['user_id' => $user->getKey()]);
        $commande = $this->createCommande();

        $response = $this->actingAs($user)
            ->post('/_test/admin/commandes/'.$commande->getKey().'/paiement', [
                'mode_paiement' => 'especes',
            ]);

        $paiement = Paiement::query()->sole();

        $response->assertRedirect(route('admin.paiements.show', $paiement));
        $this->assertSame($admin->getKey(), $paiement->admin_id);
        $this->assertSame($commande->getKey(), $paiement->commande_id);
        $this->assertSame('75.50', $paiement->montant_paye);
        $this->assertSame('especes', $paiement->mode_paiement);
        $this->assertSame('confirme', $paiement->statut);
        $this->assertNotNull($paiement->date_paiement);
    }

    public function test_admin_cannot_confirm_payment_twice_for_the_same_order(): void
    {
        $this->registerControllerRoutes();
        $user = User::factory()->create(['role' => 'admin']);
        Admin::create(['user_id' => $user->getKey()]);
        $commande = $this->createCommande();
        $commande->paiements()->create([
            'admin_id' => $user->admin->getKey(),
            'reference_paiement' => 'PAY-ALREADY-001',
            'montant_paye' => $commande->montant_total,
            'mode_paiement' => 'especes',
            'date_paiement' => now(),
            'statut' => 'confirme',
        ]);

        $response = $this->actingAs($user)
            ->from('/_test/admin/paiements')
            ->post('/_test/admin/commandes/'.$commande->getKey().'/paiement', [
                'mode_paiement' => 'especes',
            ]);

        $response->assertRedirect('/_test/admin/paiements')
            ->assertSessionHasErrors('commande');
        $this->assertDatabaseCount('paiements', 1);
    }

    public function test_admin_cannot_confirm_payment_for_a_cancelled_order(): void
    {
        $this->registerControllerRoutes();
        $user = User::factory()->create(['role' => 'admin']);
        Admin::create(['user_id' => $user->getKey()]);
        $commande = $this->createCommande(['statut' => 'annulee']);

        $response = $this->actingAs($user)
            ->from('/_test/admin/paiements')
            ->post('/_test/admin/commandes/'.$commande->getKey().'/paiement', [
                'mode_paiement' => 'especes',
            ]);

        $response->assertRedirect('/_test/admin/paiements')
            ->assertSessionHasErrors('commande');
        $this->assertDatabaseCount('paiements', 0);
    }

    private function registerControllerRoutes(): void
    {
        Route::post('/_test/admin/commandes/{commande}/paiement', [PaiementController::class, 'store'])
            ->middleware('web');
        Route::get('/_test/admin/paiements/{paiement}', fn () => response()->noContent())
            ->name('admin.paiements.show');
        Route::get('/_test/admin/paiements', fn () => response()->noContent());
        Route::getRoutes()->refreshNameLookups();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function createCommande(array $attributes = []): Commande
    {
        $client = Client::create([
            'user_id' => User::factory()->create()->getKey(),
        ]);

        return $client->commandes()->create(array_merge([
            'numero_commande' => 'CMD-'.fake()->unique()->numerify('######'),
            'montant_total' => '75.50',
            'adresse_livraison' => '1 rue du Test',
            'telephone_livraison' => '0102030405',
            'statut' => 'en_preparation',
        ], $attributes));
    }
}
