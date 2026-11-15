<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_the_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response
            ->assertOk()
            ->assertViewIs('admin.dashboard')
            ->assertSee('<svg id="commandeChart"', false)
            ->assertSee('<svg id="commandeLineChart"', false)
            ->assertSee('<svg id="commandePieChart"', false)
            ->assertSee('id="paiementsRevenueChart"', false)
            ->assertSee('width="100%" height="260"', false)
            ->assertSee('<polyline points="100,205 180,205 260,205"', false)
            ->assertSee('Aucune donnée')
            ->assertSee('Aucun paiement confirmé sur cette période.')
            ->assertSee('statistiques sont à zéro')
            ->assertDontSee('cdn.jsdelivr.net');
    }

    public function test_weekly_payment_chart_counts_only_confirmed_payments_from_the_last_seven_days(): void
    {
        $this->travelTo(Carbon::parse('2026-11-14 12:00:00'));
        $this->createPayment(250, now()->subDays(2));
        $this->createPayment(500, now()->subDays(8));
        $this->createPayment(1000, now()->subDay(), 'en_attente');
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response
            ->assertOk()
            ->assertViewHas('periodePaiements', 'semaine')
            ->assertViewHas('totalPaiementsPeriode', 250.0)
            ->assertSee('7 derniers jours')
            ->assertSee('250,00 FCFA');
    }

    public function test_monthly_payment_chart_counts_confirmed_payments_from_the_current_month(): void
    {
        $this->travelTo(Carbon::parse('2026-11-14 12:00:00'));
        $this->createPayment(250, now()->subDays(2));
        $this->createPayment(500, now()->subDays(8));
        $this->createPayment(2000, now()->subMonth());
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard', ['periode' => 'mois']));

        $response
            ->assertOk()
            ->assertViewHas('periodePaiements', 'mois')
            ->assertViewHas('totalPaiementsPeriode', 750.0)
            ->assertSee('Mois en cours')
            ->assertSee('750,00 FCFA');
    }

    public function test_invalid_payment_chart_period_is_rejected(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this
            ->actingAs($admin)
            ->from(route('admin.dashboard'))
            ->get(route('admin.dashboard', ['periode' => 'annee']));

        $response
            ->assertRedirect(route('admin.dashboard'))
            ->assertSessionHasErrors('periode');
    }

    public function test_admin_dashboard_counts_only_accounts_with_the_client_role(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create(['role' => 'client']);
        Client::query()->create(['user_id' => $admin->id]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response
            ->assertOk()
            ->assertViewHas('totalClients', 1)
            ->assertSee('Clients (1)')
            ->assertSee('Comptes clients à gérer')
            ->assertDontSee('statistiques sont à zéro');
    }

    public function test_client_cannot_view_the_admin_dashboard(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $response = $this->actingAs($client)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_guest_is_redirected_to_login_from_the_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect('/login');
    }

    private function createPayment(float $amount, Carbon $date, string $status = 'confirme'): Paiement
    {
        $client = Client::query()->create([
            'user_id' => User::factory()->create(['role' => 'client'])->getKey(),
        ]);
        $commande = $client->commandes()->create([
            'numero_commande' => 'CMD-'.fake()->unique()->numerify('######'),
            'montant_total' => $amount,
            'adresse_livraison' => '1 rue du Test',
            'telephone_livraison' => '0102030405',
        ]);

        return $commande->paiements()->create([
            'reference_paiement' => 'PAY-'.fake()->unique()->numerify('######'),
            'montant_paye' => $amount,
            'mode_paiement' => 'especes',
            'date_paiement' => $date,
            'statut' => $status,
        ]);
    }
}
