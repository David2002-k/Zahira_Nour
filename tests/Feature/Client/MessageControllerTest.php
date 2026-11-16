<?php

namespace Tests\Feature\Client;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_see_when_a_message_has_received_an_admin_reply(): void
    {
        $user = User::factory()->create(['role' => 'client']);
        $message = $this->createMessage($user);
        $admin = Admin::create([
            'user_id' => User::factory()->create(['role' => 'admin'])->getKey(),
        ]);
        $message->reponses()->create([
            'admin_id' => $admin->getKey(),
            'contenu' => 'Votre commande sera bientôt expédiée.',
        ]);

        $response = $this->actingAs($user)->get(route('client.messages.index'));

        $response->assertOk()
            ->assertViewIs('client.messages.index')
            ->assertSee('Réponse reçue')
            ->assertSee('1 réponse');
    }

    public function test_client_can_delete_own_message_and_its_replies(): void
    {
        $user = User::factory()->create(['role' => 'client']);
        $message = $this->createMessage($user);
        $admin = Admin::create([
            'user_id' => User::factory()->create(['role' => 'admin'])->getKey(),
        ]);
        $message->reponses()->create([
            'admin_id' => $admin->getKey(),
            'contenu' => 'Nous avons bien reçu votre demande.',
        ]);

        $response = $this->actingAs($user)->delete(route('client.messages.destroy', $message));

        $response->assertRedirect(route('client.messages.index'))
            ->assertSessionHas('success', 'Votre message a été supprimé.');
        $this->assertDatabaseMissing('messages', ['id' => $message->getKey()]);
        $this->assertDatabaseMissing('message_reponses', ['message_id' => $message->getKey()]);
    }

    public function test_client_cannot_delete_another_clients_message(): void
    {
        $owner = User::factory()->create(['role' => 'client']);
        $message = $this->createMessage($owner);
        $otherClient = User::factory()->create(['role' => 'client']);

        $response = $this->actingAs($otherClient)->delete(route('client.messages.destroy', $message));

        $response->assertNotFound();
        $this->assertDatabaseHas('messages', ['id' => $message->getKey()]);
    }

    private function createMessage(User $user): Message
    {
        $client = Client::query()->create(['user_id' => $user->getKey()]);

        return $client->messages()->create([
            'prenom' => $user->prenom ?? '',
            'nom' => $user->nom,
            'email' => $user->email,
            'sujet' => 'Question sur ma commande',
            'contenu' => 'Pouvez-vous me renseigner ?',
        ]);
    }
}
