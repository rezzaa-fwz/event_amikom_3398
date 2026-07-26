<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    private Event $event;

    protected function setUp(): void
    {
        parent::setUp();

        $category = Category::create([
            'name' => 'IT Seminar',
            'slug' => 'it-seminar'
        ]);

        $this->event = Event::create([
            'category_id' => $category->id,
            'title' => 'Laravel Meetup',
            'description' => 'Laravel Meetup description',
            'date' => now()->addDays(2),
            'location' => 'Amikom Cinema',
            'price' => 50000,
            'stock' => 10,
        ]);
    }

    /**
     * Test successful checkout creation.
     */
    public function test_customer_can_checkout_successfully(): void
    {
        $response = $this->post(route('checkout.store', $this->event), [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '081234567890',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('transactions', [
            'event_id' => $this->event->id,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '081234567890',
            'status' => 'Pending',
        ]);
    }

    /**
     * Test checkout validation fails for invalid input.
     */
    public function test_checkout_validation_fails_for_invalid_input(): void
    {
        $response = $this->post(route('checkout.store', $this->event), [
            'customer_name' => '',
            'customer_email' => 'invalid-email',
            'customer_phone' => '',
        ]);

        $response->assertSessionHasErrors(['customer_name', 'customer_email', 'customer_phone']);
    }

    /**
     * Test customer cannot checkout when event is sold out.
     */
    public function test_customer_cannot_checkout_when_event_sold_out(): void
    {
        $soldOutEvent = Event::create([
            'category_id' => $this->event->category_id,
            'title' => 'Sold Out Event',
            'description' => 'Sold out description',
            'date' => now()->addDays(2),
            'location' => 'Amikom Cinema',
            'price' => 50000,
            'stock' => 0,
        ]);

        $response = $this->post(route('checkout.store', $soldOutEvent), [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '081234567890',
        ]);

        $response->assertSessionHas('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        $this->assertDatabaseMissing('transactions', [
            'event_id' => $soldOutEvent->id,
        ]);
    }
}
