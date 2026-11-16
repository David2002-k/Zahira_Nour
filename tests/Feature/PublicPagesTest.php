<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicPagesTest extends TestCase
{
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
}
