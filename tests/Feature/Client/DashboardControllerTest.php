<?php

namespace Tests\Feature\Client;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_client_activity_and_recent_orders(): void
    {
        $user = User::factory()->create();
        $client = Client::create(['user_id' => $user->getKey()]);
        $client->commandes()->create([
            'numero_commande' => 'CMD-CLIENT-001',
            'montant_total' => '12500.00',
            'statut' => 'en_preparation',
            'adresse_livraison' => '1 rue du Test',
            'telephone_livraison' => '0102030405',
            'date_commande' => now()->subDay(),
        ]);
        $commandeRecente = $client->commandes()->create([
            'numero_commande' => 'CMD-CLIENT-002',
            'montant_total' => '5000.00',
            'statut' => 'livree',
            'adresse_livraison' => '2 rue du Test',
            'telephone_livraison' => '0102030405',
            'date_commande' => now(),
        ]);
        $client->messages()->create([
            'prenom' => $user->prenom ?? '',
            'nom' => $user->nom,
            'email' => $user->email,
            'sujet' => 'Question sur une commande',
            'contenu' => 'Bonjour, où en est ma commande ?',
        ]);

        $response = $this->actingAs($user)->get(route('client.dashboard'));

        $response->assertOk()
            ->assertViewIs('client.dashboard')
            ->assertViewHas('commandesEnCours', 1)
            ->assertViewHas('totalCommandes', 2)
            ->assertViewHas('messagesEnvoyes', 1)
            ->assertSee('Commandes en cours')
            ->assertSee('Commandes au total')
            ->assertSee('Messages envoyés')
            ->assertSee('CMD-CLIENT-002')
            ->assertSee('CMD-CLIENT-001')
            ->assertSee('5 000,00 FCFA')
            ->assertSee('En préparation')
            ->assertSee('Livrée')
            ->assertSee(route('client.commandes.show', $commandeRecente));
    }

    public function test_dashboard_offers_the_shop_when_the_client_has_no_orders(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('client.dashboard'));

        $response->assertOk()
            ->assertViewHas('commandesEnCours', 0)
            ->assertViewHas('totalCommandes', 0)
            ->assertViewHas('messagesEnvoyes', 0)
            ->assertSee('Vous n’avez pas encore passé de commande.')
            ->assertSee(route('client.boutique.index'));
    }
}
