<?php

namespace Tests\Feature\Models;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Message;
use App\Models\MessageReponse;
use App\Models\Paiement;
use App\Models\ReseauSocial;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminRelationsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_replies_payments_and_social_networks_resolve_their_relations(): void
    {
        $admin = Admin::create([
            'user_id' => User::factory()->create()->id,
            'biographie' => 'Administrateur',
        ]);
        $client = Client::create([
            'user_id' => User::factory()->create()->id,
        ]);
        $message = Message::create([
            'client_id' => $client->id,
            'prenom' => 'Client',
            'nom' => 'Test',
            'email' => 'client@example.com',
            'sujet' => 'Question',
            'contenu' => 'Bonjour',
        ]);
        $reponse = MessageReponse::create([
            'message_id' => $message->id,
            'admin_id' => $admin->id,
            'contenu' => 'Réponse',
        ]);
        $reseauSocial = ReseauSocial::create([
            'admin_id' => $admin->id,
            'nom' => 'Instagram',
            'url' => 'https://example.com',
        ]);
        $commande = Commande::create([
            'client_id' => $client->id,
            'numero_commande' => 'CMD-ADMIN-001',
            'adresse_livraison' => '1 rue du Test',
            'telephone_livraison' => '0102030405',
        ]);
        $paiement = Paiement::create([
            'admin_id' => $admin->id,
            'commande_id' => $commande->id,
            'reference_paiement' => 'PAY-ADMIN-001',
            'montant_paye' => 12.50,
            'mode_paiement' => 'especes',
            'date_paiement' => '2026-11-04 10:00:00',
        ]);

        $this->assertSame($admin->getKey(), $admin->user->admin->getKey());
        $this->assertSame([$reponse->getKey()], $admin->messageReponses->modelKeys());
        $this->assertSame([$paiement->getKey()], $admin->paiements->modelKeys());
        $this->assertSame([$reseauSocial->getKey()], $admin->reseauxSociaux->modelKeys());
        $this->assertSame($admin->getKey(), $reponse->admin->getKey());
        $this->assertSame($message->getKey(), $reponse->message->getKey());
        $this->assertSame([$reponse->getKey()], $message->reponses->modelKeys());
        $this->assertSame($admin->getKey(), $paiement->admin->getKey());
        $this->assertSame($commande->getKey(), $paiement->commande->getKey());
        $this->assertSame($admin->getKey(), $reseauSocial->admin->getKey());
    }
}
