<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Categorie;
use App\Models\Produit;
use Tests\TestCase;

class BoutiqueControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_boutique_lists_available_products_for_guests(): void
    {
        $categorie = Categorie::create([
            'nom' => 'Bijoux',
            'slug' => 'bijoux',
        ]);
        Produit::create([
            'categorie_id' => $categorie->getKey(),
            'nom' => 'Bague dorée',
            'slug' => 'bague-doree',
            'description' => 'Une bague élégante.',
            'prix' => '12500.00',
            'stock' => 3,
            'statut' => 'disponible',
        ]);
        Produit::create([
            'categorie_id' => $categorie->getKey(),
            'nom' => 'Produit indisponible',
            'slug' => 'produit-indisponible',
            'description' => 'Ce produit n’est pas disponible.',
            'prix' => '5000.00',
            'stock' => 1,
            'statut' => 'indisponible',
        ]);

        $response = $this->get(route('public.boutique'));

        $response->assertOk()
            ->assertViewIs('boutique')
            ->assertSee('Bague dorée')
            ->assertSee('Bijoux')
            ->assertDontSee('Produit indisponible')
            ->assertDontSee('Ajouter au panier');
    }

    public function test_homepage_product_links_open_the_public_boutique(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee(route('public.boutique'), false)
            ->assertDontSee(route('client.boutique.index'), false);
    }
}
