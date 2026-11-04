<?php

namespace Tests\Feature\Models;

use App\Models\Categorie;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Ligne_commande;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class CommandeRelationsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_order_resolves_its_client_lines_and_payments(): void
    {
        $client = Client::create([
            'user_id' => User::factory()->create()->id,
        ]);
        $commande = Commande::create([
            'client_id' => $client->id,
            'numero_commande' => 'CMD-RELATION-001',
            'adresse_livraison' => '1 rue du Test',
            'telephone_livraison' => '0102030405',
        ]);
        $categorie = Categorie::create([
            'nom' => 'Soins',
            'slug' => 'soins',
        ]);
        $produit = Produit::create([
            'categorie_id' => $categorie->id,
            'nom' => 'Savon naturel',
            'slug' => 'savon-naturel',
            'prix' => 5,
        ]);
        $ligneCommande = Ligne_commande::create([
            'commande_id' => $commande->id,
            'produit_id' => $produit->id,
            'quantite' => 1,
            'prix_unitaire' => 5,
            'sous_total' => 5,
        ]);
        $paiement = Paiement::create([
            'commande_id' => $commande->id,
            'reference_paiement' => 'PAY-RELATION-001',
            'montant_paye' => 5,
            'mode_paiement' => 'especes',
            'date_paiement' => '2026-11-04 10:00:00',
        ]);

        $this->assertSame($client->getKey(), $commande->client->getKey());
        $this->assertSame([$ligneCommande->getKey()], $commande->lignesCommande->modelKeys());
        $this->assertSame([$paiement->getKey()], $commande->paiements->modelKeys());
    }
}
