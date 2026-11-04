<?php

namespace Tests\Feature\Models;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Message;
use App\Models\Temoignage;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_client_relations_load_their_expected_records(): void
    {
        $user = User::factory()->create();
        $client = Client::create(['user_id' => $user->id]);

        $commande = Commande::create([
            'client_id' => $client->id,
            'numero_commande' => 'CMD-TEST-001',
            'adresse_livraison' => '1 rue du Test',
            'telephone_livraison' => '0102030405',
        ]);
        $message = Message::create([
            'client_id' => $client->id,
            'prenom' => 'Test',
            'nom' => 'Client',
            'email' => 'client@example.com',
            'sujet' => 'Question',
            'contenu' => 'Contenu du message',
        ]);
        $temoignage = Temoignage::create([
            'client_id' => $client->id,
            'contenu' => 'Excellent service',
        ]);

        $this->assertSame($user->getKey(), $client->user->getKey());
        $this->assertSame($client->getKey(), $user->client->getKey());
        $this->assertSame([$commande->getKey()], $client->commandes->modelKeys());
        $this->assertSame([$message->getKey()], $client->messages->modelKeys());
        $this->assertSame([$temoignage->getKey()], $client->temoignages->modelKeys());
    }
}
