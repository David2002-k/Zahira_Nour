<?php

namespace Tests\Feature\Admin;

use App\Models\Client;
use App\Models\Temoignage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TemoignageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_a_testimonial(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $temoignage = $this->createTemoignage();

        $response = $this->actingAs($admin)->delete(route('admin.temoignages.destroy', $temoignage));

        $response->assertRedirect(route('admin.temoignages.index'))
            ->assertSessionHas('success', 'Le témoignage a été supprimé.');
        $this->assertDatabaseMissing('temoignages', ['id' => $temoignage->getKey()]);
    }

    public function test_client_cannot_delete_a_testimonial_from_admin_moderation(): void
    {
        $client = User::factory()->create(['role' => 'client']);
        $temoignage = $this->createTemoignage();

        $response = $this->actingAs($client)->delete(route('admin.temoignages.destroy', $temoignage));

        $response->assertForbidden();
        $this->assertDatabaseHas('temoignages', ['id' => $temoignage->getKey()]);
    }

    private function createTemoignage(): Temoignage
    {
        $client = Client::query()->create([
            'user_id' => User::factory()->create(['role' => 'client'])->getKey(),
        ]);

        return $client->temoignages()->create([
            'contenu' => 'Un excellent service.',
            'statut' => 'en_attente',
        ]);
    }
}
