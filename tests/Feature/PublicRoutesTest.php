<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\Partner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the home page returns successful response and has correct view data.
     */
    public function test_home_page_returns_successful_response(): void
    {
        // Seed category, partner, and event
        $category = Category::create([
            'name' => 'Seminar IT',
            'slug' => 'seminar-it',
        ]);

        $partner = Partner::create([
            'name' => 'Amikom Partner',
            'logo_url' => 'logos/partner.png',
        ]);

        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Sample Event',
            'description' => 'Sample description',
            'date' => now()->addDays(5),
            'location' => 'Amikom',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event.png',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertViewHas('events');
        $response->assertViewHas('partners');
    }

    /**
     * Test static page routes.
     */
    public function test_static_pages_return_successful_response(): void
    {
        $staticRoutes = [
            '/kontak' => 'contact',
            '/profil' => 'profile',
            '/katalog' => 'catalog',
            '/bantuan' => 'bantuan',
        ];

        foreach ($staticRoutes as $route => $view) {
            $response = $this->get($route);
            $response->assertStatus(200);
            $response->assertViewIs($view);
        }
    }

    /**
     * Test showing details of a specific event.
     */
    public function test_show_event_detail(): void
    {
        $category = Category::create([
            'name' => 'Seminar IT',
            'slug' => 'seminar-it',
        ]);

        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Sample Event',
            'description' => 'Sample description',
            'date' => now()->addDays(5),
            'location' => 'Amikom',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event.png',
        ]);

        $response = $this->get(route('events.show', $event));

        $response->assertStatus(200);
        $response->assertViewIs('event-detail');
        $response->assertViewHas('event');
        $response->assertViewHas('categories');
    }

    /**
     * Test the public checkout view route.
     */
    public function test_public_checkout_view(): void
    {
        $response = $this->get('/checkout');

        $response->assertStatus(200);
        $response->assertViewIs('checkout');
    }

    /**
     * Test the ticket show route.
     */
    public function test_ticket_show_view(): void
    {
        $response = $this->get('/ticket');

        $response->assertStatus(200);
        $response->assertViewIs('ticket');
    }
}
