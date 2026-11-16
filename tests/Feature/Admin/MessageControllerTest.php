<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_a_message_and_its_replies(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $client = Client::query()->create([
            'user_id' => User::factory()->create(['role' => 'client'])->getKey(),
        ]);
        $message = $this->createMessage($client);
        $admin = Admin::query()->create(['user_id' => $adminUser->getKey()]);
        $message->reponses()->create([
            'admin_id' => $admin->getKey(),
            'contenu' => 'Nous avons bien reçu votre demande.',
        ]);

        $response = $this->actingAs($adminUser)->delete(route('admin.messages.destroy', $message));

        $response->assertRedirect(route('admin.messages.index'))
            ->assertSessionHas('success', 'Le message a été supprimé.');
        $this->assertDatabaseMissing('messages', ['id' => $message->getKey()]);
        $this->assertDatabaseMissing('message_reponses', ['message_id' => $message->getKey()]);
    }

    public function test_client_cannot_delete_a_message_from_the_admin_inbox(): void
    {
        $clientUser = User::factory()->create(['role' => 'client']);
        $owner = Client::query()->create([
            'user_id' => User::factory()->create(['role' => 'client'])->getKey(),
        ]);
        $message = $this->createMessage($owner);

        $response = $this->actingAs($clientUser)->delete(route('admin.messages.destroy', $message));

        $response->assertForbidden();
        $this->assertDatabaseHas('messages', ['id' => $message->getKey()]);
    }

    private function createMessage(Client $client): Message
    {
        $user = $client->user;

        return $client->messages()->create([
            'prenom' => $user->prenom ?? '',
            'nom' => $user->nom,
            'email' => $user->email,
            'sujet' => 'Question sur ma commande',
            'contenu' => 'Pouvez-vous me renseigner ?',
        ]);
    }
}
