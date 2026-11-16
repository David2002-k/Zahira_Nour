<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Temoignage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TemoignageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitors_see_only_approved_testimonials(): void
    {
        $user = User::factory()->create([
            'role' => 'client',
            'prenom' => 'Aminata',
            'nom' => 'Diop',
        ]);
        $client = Client::create(['user_id' => $user->getKey()]);
        Temoignage::create([
            'client_id' => $client->getKey(),
            'contenu' => 'Une très belle expérience.',
            'statut' => 'approuve',
            'date_publication' => now(),
        ]);
        Temoignage::create([
            'client_id' => $client->getKey(),
            'contenu' => 'Ce témoignage attend encore sa validation.',
            'statut' => 'en_attente',
        ]);

        $response = $this->get(route('public.temoignages'));

        $response->assertOk()
            ->assertViewIs('temoignage')
            ->assertSee('Une très belle expérience.')
            ->assertSee('Aminata Diop')
            ->assertDontSee('Ce témoignage attend encore sa validation.');
    }

    public function test_visitors_see_an_empty_state_when_there_are_no_approved_testimonials(): void
    {
        $response = $this->get(route('public.temoignages'));

        $response->assertOk()
            ->assertSee('Aucun témoignage publié pour le moment');
    }
}
