<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response
            ->assertOk()
            ->assertSee('Heureuse de vous retrouver')
            ->assertSee('Adresse e-mail')
            ->assertSee('Mot de passe')
            ->assertSee('Se connecter')
            ->assertSee('Créer un compte');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create(['role' => 'client']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('client.dashboard', absolute: false));
    }

    public function test_admins_are_redirected_to_the_admin_dashboard_after_login(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard', absolute: false));
    }

    public function test_client_login_does_not_redirect_to_an_intended_admin_dashboard(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $response = $this
            ->withSession(['url.intended' => route('admin.dashboard', absolute: false)])
            ->post('/login', [
                'email' => $client->email,
                'password' => 'password',
            ]);

        $this->assertAuthenticatedAs($client);
        $response
            ->assertRedirect(route('client.dashboard', absolute: false))
            ->assertSessionMissing('url.intended');
    }

    public function test_login_validation_messages_are_in_french(): void
    {
        $response = $this->from('/login')->post('/login', []);

        $response->assertSessionHasErrors([
            'email' => 'Veuillez saisir votre adresse e-mail.',
            'password' => 'Veuillez saisir votre mot de passe.',
        ]);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors([
            'email' => 'L’adresse e-mail ou le mot de passe est incorrect.',
        ]);
    }

    public function test_blocked_clients_cannot_authenticate(): void
    {
        $client = User::factory()->create([
            'role' => 'client',
            'statut' => 'bloque',
        ]);

        $response = $this->post('/login', [
            'email' => $client->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors([
            'email' => 'Votre compte client est bloqué. Veuillez contacter l’administration.',
        ]);
    }

    public function test_blocked_clients_cannot_access_the_client_dashboard(): void
    {
        $client = User::factory()->create([
            'role' => 'client',
            'statut' => 'bloque',
        ]);

        $response = $this->actingAs($client)->get(route('client.dashboard'));

        $response->assertForbidden();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
