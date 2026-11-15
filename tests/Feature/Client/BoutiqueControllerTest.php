<?php

namespace Tests\Feature\Client;

use App\Models\Categorie;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoutiqueControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_boutique_displays_available_products_and_add_to_cart_actions(): void
    {
        $user = User::factory()->create();
        $categorie = Categorie::create([
            'nom' => 'Bijoux',
            'slug' => 'bijoux',
        ]);
        $produit = Produit::create([
            'categorie_id' => $categorie->getKey(),
            'photo' => 'produits/bague.jpg',
            'nom' => 'Bague dorée',
            'slug' => 'bague-doree',
            'description' => 'Une bague élégante.',
            'prix' => '12500.00',
            'stock' => 3,
            'statut' => 'disponible',
        ]);
        Produit::create([
            'categorie_id' => $categorie->getKey(),
            'nom' => 'Produit caché',
            'slug' => 'produit-cache',
            'description' => 'Ce produit n’est pas disponible.',
            'prix' => '5000.00',
            'stock' => 1,
            'statut' => 'indisponible',
        ]);

        $response = $this->actingAs($user)->get(route('client.boutique.index'));

        $response->assertOk()
            ->assertViewIs('client.boutique.index')
            ->assertSee('Bague dorée')
            ->assertSee('Bijoux')
            ->assertSee('storage/produits/bague.jpg')
            ->assertSee('12 500,00 FCFA')
            ->assertSee(route('client.panier.add', $produit))
            ->assertDontSee('Produit caché');
    }

    public function test_boutique_displays_an_empty_state_when_no_products_are_available(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('client.boutique.index'));

        $response->assertOk()
            ->assertSee('La boutique est momentanément vide')
            ->assertDontSee('Ajouter au panier');
    }
}
