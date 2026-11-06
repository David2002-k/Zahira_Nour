<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertSee('name="prenom"', false)
            ->assertSee('name="nom"', false)
            ->assertSee('name="telephone"', false)
            ->assertSee('Créer un compte')
            ->assertSee('Prénom')
            ->assertSee('Nom')
            ->assertSee('Mot de passe')
            ->assertSee('Créer mon compte');
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'prenom' => 'Jane',
            'nom' => 'Test User',
            'telephone' => '0612345678',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'prenom' => 'Jane',
            'nom' => 'Test User',
            'telephone' => '0612345678',
            'email' => 'test@example.com',
        ]);
        $user = User::query()->where('email', 'test@example.com')->firstOrFail();
        $this->assertDatabaseHas('clients', [
            'user_id' => $user->getKey(),
        ]);
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_registration_validation_messages_are_in_french(): void
    {
        $response = $this->from('/register')->post('/register', []);

        $response->assertSessionHasErrors([
            'nom' => 'Le champ nom est obligatoire.',
            'prenom' => 'Le champ prénom est obligatoire.',
            'email' => 'Le champ adresse e-mail est obligatoire.',
            'password' => 'Le champ mot de passe est obligatoire.',
        ]);
    }
}
