<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $nonAdmin;

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
    }

    /**
     * Test non-admin and guests are restricted from managing categories.
     */
    public function test_non_admin_cannot_access_categories(): void
    {
        // Guest redirect to login
        $this->get(route('admin.categories'))
            ->assertRedirect('admin/login');

        // Regular user receives 403
        $this->actingAs($this->nonAdmin)
            ->get(route('admin.categories'))
            ->assertStatus(403);
    }

    /**
     * Test admin can view categories list and search works.
     */
    public function test_admin_can_view_categories_list_and_search(): void
    {
        $cat1 = Category::create(['name' => 'Web Development', 'slug' => 'web-development']);
        $cat2 = Category::create(['name' => 'Graphic Design', 'slug' => 'graphic-design']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.categories'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.index');
        $response->assertSee('Web Development');
        $response->assertSee('Graphic Design');

        // Test search
        $searchResponse = $this->actingAs($this->admin)
            ->get(route('admin.categories', ['search' => 'Web']));
        
        $searchResponse->assertSee('Web Development');
        $searchResponse->assertDontSee('Graphic Design');
    }

    /**
     * Test admin can store a new category with an optional image.
     */
    public function test_admin_can_store_category(): void
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('category.png');

        $response = $this->actingAs($this->admin)
            ->post(route('admin.categories.store'), [
                'name' => 'Artificial Intelligence',
                'image' => $image,
            ]);

        $response->assertRedirect(route('admin.categories'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Artificial Intelligence',
            'slug' => 'artificial-intelligence',
        ]);

        $category = Category::where('name', 'Artificial Intelligence')->first();
        $this->assertNotNull($category->image);
        Storage::disk('public')->assertExists($category->image);
    }

    /**
     * Test store category validation.
     */
    public function test_store_category_validation(): void
    {
        // Name is required
        $response = $this->actingAs($this->admin)
            ->post(route('admin.categories.store'), [
                'name' => '',
            ]);
        $response->assertSessionHasErrors('name');

        // Name must be unique
        Category::create(['name' => 'Duplicate', 'slug' => 'duplicate']);
        $response2 = $this->actingAs($this->admin)
            ->post(route('admin.categories.store'), [
                'name' => 'Duplicate',
            ]);
        $response2->assertSessionHasErrors('name');
    }

    /**
     * Test admin can update an existing category.
     */
    public function test_admin_can_update_category(): void
    {
        Storage::fake('public');

        $category = Category::create([
            'name' => 'Machine Learning',
            'slug' => 'machine-learning',
            'image' => 'categories/old.png'
        ]);

        $newImage = UploadedFile::fake()->image('new-category.png');

        $response = $this->actingAs($this->admin)
            ->put(route('admin.categories.update', $category), [
                'name' => 'Deep Learning',
                'image' => $newImage,
            ]);

        $response->assertRedirect(route('admin.categories'));
        
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Deep Learning',
            'slug' => 'deep-learning',
        ]);

        $category->refresh();
        Storage::disk('public')->assertExists($category->image);
        Storage::disk('public')->assertMissing('categories/old.png');
    }

    /**
     * Test admin can delete a category.
     */
    public function test_admin_can_delete_category(): void
    {
        Storage::fake('public');

        $category = Category::create([
            'name' => 'Cyber Security',
            'slug' => 'cyber-security',
            'image' => 'categories/cyber.png'
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories'));
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
        Storage::disk('public')->assertMissing('categories/cyber.png');
    }
}
