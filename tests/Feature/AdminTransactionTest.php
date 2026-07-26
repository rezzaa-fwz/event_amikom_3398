<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTransactionTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $nonAdmin;
    private Event $event;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::forceCreate([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->nonAdmin = User::forceCreate([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $category = Category::create([
            'name' => 'Seminar',
            'slug' => 'seminar',
        ]);

        $this->event = Event::create([
            'category_id' => $category->id,
            'title' => 'Web Dev Workshop',
            'description' => 'Learn coding',
            'date' => now()->addDays(2),
            'location' => 'Amikom Cinema',
            'price' => 20000,
            'stock' => 50,
        ]);
    }

    /**
     * Test non-admin and guests cannot access transactions page.
     */
    public function test_non_admin_cannot_access_transactions(): void
    {
        $this->get(route('admin.transactions.index'))
            ->assertRedirect('admin/login');

        $this->actingAs($this->nonAdmin)
            ->get(route('admin.transactions.index'))
            ->assertStatus(403);
    }

    /**
     * Test admin can view transactions listing.
     */
    public function test_admin_can_view_transactions_listing(): void
    {
        $transaction = Transaction::create([
            'event_id' => $this->event->id,
            'order_id' => 'TRX-12345',
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '081234567890',
            'total_price' => 25000,
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.transactions.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.transactions.index');
        $response->assertSee('John Doe');
        $response->assertSee('TRX-12345');
        $response->assertSee('Web Dev Workshop'); // Verifies relationship is loaded
    }
}
