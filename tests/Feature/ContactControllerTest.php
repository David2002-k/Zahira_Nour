<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_the_contact_page(): void
    {
        $response = $this->get(route('public.contact'));

        $response->assertOk()
            ->assertViewIs('contact')
            ->assertSee(route('public.contact.store'), false);
    }

    public function test_guest_can_send_a_contact_message(): void
    {
        $response = $this->from(route('public.contact'))
            ->post(route('public.contact.store'), [
                'prenom' => 'Aminata',
                'nom' => 'Diop',
                'email' => 'aminata@example.test',
                'sujet' => 'Question sur un produit',
                'contenu' => 'Pouvez-vous me renseigner sur ce produit ?',
            ]);

        $response->assertRedirect(route('public.contact'))
            ->assertSessionHas('success', 'Votre message a été envoyé.');

        $this->assertDatabaseHas('messages', [
            'client_id' => null,
            'prenom' => 'Aminata',
            'nom' => 'Diop',
            'email' => 'aminata@example.test',
            'sujet' => 'Question sur un produit',
            'contenu' => 'Pouvez-vous me renseigner sur ce produit ?',
            'statut' => 'non_lu',
        ]);
    }

    public function test_contact_form_rejects_missing_fields(): void
    {
        $response = $this->from(route('public.contact'))
            ->post(route('public.contact.store'), []);

        $response->assertRedirect(route('public.contact'))
            ->assertSessionHasErrors(['prenom', 'nom', 'email', 'sujet', 'contenu']);

        $this->assertDatabaseCount('messages', 0);
    }

    public function test_contact_form_rejects_an_invalid_email_address(): void
    {
        $response = $this->from(route('public.contact'))
            ->post(route('public.contact.store'), [
                'prenom' => 'Aminata',
                'nom' => 'Diop',
                'email' => 'not-an-email',
                'sujet' => 'Question sur un produit',
                'contenu' => 'Pouvez-vous me renseigner sur ce produit ?',
            ]);

        $response->assertRedirect(route('public.contact'))
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseCount('messages', 0);
    }
}
