<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminEventTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $nonAdmin;
    private Category $category;

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

        $this->category = Category::create([
            'name' => 'Seminar',
            'slug' => 'seminar',
        ]);
    }

    /**
     * Test non-admin and guests cannot access event routes.
     */
    public function test_non_admin_cannot_access_events(): void
    {
        $this->get(route('admin.events.index'))
            ->assertRedirect('admin/login');

        $this->actingAs($this->nonAdmin)
            ->get(route('admin.events.index'))
            ->assertStatus(403);
    }

    /**
     * Test admin can view events list and search.
     */
    public function test_admin_can_view_events_list_and_search(): void
    {
        $e1 = Event::create([
            'category_id' => $this->category->id,
            'title' => 'Web Dev Workshop',
            'description' => 'Learn coding',
            'date' => now()->addDays(2),
            'location' => 'Amikom Cinema',
            'price' => 20000,
            'stock' => 50,
        ]);

        $e2 = Event::create([
            'category_id' => $this->category->id,
            'title' => 'UI/UX Masterclass',
            'description' => 'Learn design',
            'date' => now()->addDays(3),
            'location' => 'Amikom Unit 6',
            'price' => 30000,
            'stock' => 40,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.events.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.events.index');
        $response->assertSee('Web Dev Workshop');
        $response->assertSee('UI/UX Masterclass');

        // Test search
        $searchResponse = $this->actingAs($this->admin)
            ->get(route('admin.events.index', ['search' => 'Workshop']));
        
        $searchResponse->assertSee('Web Dev Workshop');
        $searchResponse->assertDontSee('UI/UX Masterclass');
    }

    /**
     * Test admin can store a new event.
     */
    public function test_admin_can_store_event(): void
    {
        Storage::fake('public');

        $poster = UploadedFile::fake()->image('poster.png');

        $response = $this->actingAs($this->admin)
            ->post(route('admin.events.store'), [
                'category_id' => $this->category->id,
                'title' => 'Laravel Meetup',
                'description' => 'Laravel community event',
                'date' => '2026-08-10 10:00:00',
                'location' => 'Amikom Hall',
                'price' => 0,
                'stock' => 200,
                'poster' => $poster,
            ]);

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', [
            'title' => 'Laravel Meetup',
            'location' => 'Amikom Hall',
            'price' => 0,
            'stock' => 200,
        ]);

        $event = Event::where('title', 'Laravel Meetup')->first();
        $this->assertNotNull($event->poster_path);
        Storage::disk('public')->assertExists($event->poster_path);
    }

    /**
     * Test admin can update event details.
     */
    public function test_admin_can_update_event(): void
    {
        Storage::fake('public');

        $event = Event::create([
            'category_id' => $this->category->id,
            'title' => 'Old Title',
            'description' => 'Old description',
            'date' => '2026-08-10 10:00:00',
            'location' => 'Old Location',
            'price' => 15000,
            'stock' => 50,
            'poster_path' => 'posters/old-poster.png'
        ]);

        $newPoster = UploadedFile::fake()->image('new-poster.png');

        $response = $this->actingAs($this->admin)
            ->put(route('admin.events.update', $event), [
                'category_id' => $this->category->id,
                'title' => 'New Title',
                'description' => 'New description',
                'date' => '2026-08-11 11:00:00',
                'location' => 'New Location',
                'price' => 25000,
                'stock' => 75,
                'poster' => $newPoster,
            ]);

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'New Title',
            'location' => 'New Location',
            'price' => 25000,
            'stock' => 75,
        ]);

        $event->refresh();
        Storage::disk('public')->assertExists($event->poster_path);
        Storage::disk('public')->assertMissing('posters/old-poster.png');
    }

    /**
     * Test admin can delete event.
     */
    public function test_admin_can_delete_event(): void
    {
        Storage::fake('public');

        $event = Event::create([
            'category_id' => $this->category->id,
            'title' => 'Delete Me',
            'description' => 'To be deleted',
            'date' => '2026-08-10 10:00:00',
            'location' => 'Delete Hall',
            'price' => 10000,
            'stock' => 10,
            'poster_path' => 'posters/delete-poster.png'
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.events.destroy', $event));

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseMissing('events', [
            'id' => $event->id,
        ]);
        Storage::disk('public')->assertMissing('posters/delete-poster.png');
    }
}
