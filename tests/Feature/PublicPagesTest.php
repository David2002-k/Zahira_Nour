<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\ReseauSocial;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_why_us_page_is_accessible_to_visitors(): void
    {
        $response = $this->get(route('public.pourquoi-nous'));

        $response->assertOk()
            ->assertViewIs('pourquoi_nous')
            ->assertSee('Pourquoi choisir Zahira Nour ?');
    }

    public function test_homepage_links_to_the_public_information_pages(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee(route('public.pourquoi-nous'), false)
            ->assertSee(route('public.temoignages'), false)
            ->assertSee(route('public.contact'), false)
            ->assertSee(route('public.contact.store'), false);
    }

    public function test_homepage_renders_social_network_links_and_icons(): void
    {
        $admin = Admin::create([
            'user_id' => User::factory()->create()->id,
            'biographie' => 'Administrateur',
        ]);
        ReseauSocial::create([
            'admin_id' => $admin->id,
            'nom' => 'Instagram',
            'url' => 'https://instagram.com/zahiranour',
            'icone' => 'instagram',
        ]);

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('href="https://instagram.com/zahiranour"', false)
            ->assertSee('aria-label="Instagram"', false)
            ->assertSee('<i class="fa fa-instagram" aria-hidden="true"></i>', false);
    }
}
