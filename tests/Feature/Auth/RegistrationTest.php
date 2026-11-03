<?php

namespace Tests\Feature\Auth;

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
            ->assertSee('name="telephone"', false);
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
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
