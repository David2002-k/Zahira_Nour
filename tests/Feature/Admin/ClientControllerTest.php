<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_client_accounts_without_admin_accounts(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create([
            'role' => 'client',
            'email' => 'client@example.com',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.clients.index'));

        $response
            ->assertOk()
            ->assertViewIs('admin.clients.index')
            ->assertSee($client->email)
            ->assertDontSee($admin->email)
            ->assertSee('Gestion des comptes clients')
            ->assertSee('Bloquer le compte');
    }

    public function test_admin_can_block_a_client_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create(['role' => 'client']);

        $response = $this
            ->actingAs($admin)
            ->patch(route('admin.clients.update-status', $client), [
                'statut' => 'bloque',
            ]);

        $response->assertRedirect(route('admin.clients.index'));
        $this->assertDatabaseHas('users', [
            'id' => $client->id,
            'statut' => 'bloque',
        ]);
    }

    public function test_admin_can_unblock_a_client_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create([
            'role' => 'client',
            'statut' => 'bloque',
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(route('admin.clients.update-status', $client), [
                'statut' => 'actif',
            ]);

        $response->assertRedirect(route('admin.clients.index'));
        $this->assertDatabaseHas('users', [
            'id' => $client->id,
            'statut' => 'actif',
        ]);
    }

    public function test_client_cannot_view_client_account_management(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $response = $this->actingAs($client)->get(route('admin.clients.index'));

        $response->assertForbidden();
    }

    public function test_client_cannot_change_an_account_status(): void
    {
        $client = User::factory()->create(['role' => 'client']);
        $otherClient = User::factory()->create(['role' => 'client']);

        $response = $this
            ->actingAs($client)
            ->patch(route('admin.clients.update-status', $otherClient), [
                'statut' => 'bloque',
            ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('users', [
            'id' => $otherClient->id,
            'statut' => 'actif',
        ]);
    }

    public function test_admin_cannot_change_an_admin_account_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $otherAdmin = User::factory()->create(['role' => 'admin']);

        $response = $this
            ->actingAs($admin)
            ->patch(route('admin.clients.update-status', $otherAdmin), [
                'statut' => 'bloque',
            ]);

        $response->assertNotFound();
        $this->assertDatabaseHas('users', [
            'id' => $otherAdmin->id,
            'statut' => 'actif',
        ]);
    }

    public function test_invalid_client_status_is_rejected(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create(['role' => 'client']);

        $response = $this
            ->actingAs($admin)
            ->patch(route('admin.clients.update-status', $client), [
                'statut' => 'inactif',
            ]);

        $response->assertSessionHasErrors('statut');
        $this->assertDatabaseHas('users', [
            'id' => $client->id,
            'statut' => 'actif',
        ]);
    }

    public function test_guest_is_redirected_to_login_from_client_account_management(): void
    {
        $response = $this->get(route('admin.clients.index'));

        $response->assertRedirect('/login');
    }
}
