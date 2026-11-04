<?php

namespace Tests\Feature\Models;

use App\Models\Categorie;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Ligne_commande;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class CatalogRelationsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_products_and_order_lines_resolve_their_catalog_relations(): void
    {
        $categorie = Categorie::create([
            'nom' => 'Soins',
            'slug' => 'soins',
        ]);
        $produit = Produit::create([
            'categorie_id' => $categorie->id,
            'nom' => 'Huile naturelle',
            'slug' => 'huile-naturelle',
            'prix' => 12.50,
        ]);
        $client = Client::create([
            'user_id' => User::factory()->create()->id,
        ]);
        $commande = Commande::create([
            'client_id' => $client->id,
            'numero_commande' => 'CMD-CATALOG-001',
            'adresse_livraison' => '1 rue du Test',
            'telephone_livraison' => '0102030405',
        ]);
        $ligneCommande = Ligne_commande::create([
            'commande_id' => $commande->id,
            'produit_id' => $produit->id,
            'quantite' => 2,
            'prix_unitaire' => 12.50,
            'sous_total' => 25,
        ]);

        $this->assertSame($categorie->getKey(), $produit->categorie->getKey());
        $this->assertSame([$produit->getKey()], $categorie->produits->modelKeys());
        $this->assertSame($produit->getKey(), $ligneCommande->produit->getKey());
        $this->assertSame($commande->getKey(), $ligneCommande->commande->getKey());
        $this->assertSame([$ligneCommande->getKey()], $produit->lignesCommande->modelKeys());
    }
}
