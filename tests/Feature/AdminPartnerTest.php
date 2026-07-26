<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPartnerTest extends TestCase
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
     * Test non-admin and guests cannot access partner routes.
     */
    public function test_non_admin_cannot_access_partners(): void
    {
        $this->get(route('admin.partners.index'))
            ->assertRedirect('admin/login');

        $this->actingAs($this->nonAdmin)
            ->get(route('admin.partners.index'))
            ->assertStatus(403);
    }

    /**
     * Test admin can view partners list and search.
     */
    public function test_admin_can_view_partners_list_and_search(): void
    {
        $p1 = Partner::create(['name' => 'Gojek', 'logo_url' => 'partners/gojek.png']);
        $p2 = Partner::create(['name' => 'Grab', 'logo_url' => 'partners/grab.png']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.partners.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.partners.index');
        $response->assertSee('Gojek');
        $response->assertSee('Grab');

        // Test search
        $searchResponse = $this->actingAs($this->admin)
            ->get(route('admin.partners.index', ['search' => 'Gojek']));
        
        $searchResponse->assertSee('Gojek');
        $searchResponse->assertDontSee('Grab');
    }

    /**
     * Test admin can store a new partner.
     */
    public function test_admin_can_store_partner(): void
    {
        Storage::fake('public');

        $logo = UploadedFile::fake()->image('partner-logo.png');

        $response = $this->actingAs($this->admin)
            ->post(route('admin.partners.store'), [
                'name' => 'Tokopedia',
                'logo' => $logo,
            ]);

        $response->assertRedirect(route('admin.partners.index'));
        $this->assertDatabaseHas('partners', [
            'name' => 'Tokopedia',
        ]);

        $partner = Partner::where('name', 'Tokopedia')->first();
        $this->assertNotNull($partner->logo_url);
        Storage::disk('public')->assertExists($partner->logo_url);
    }

    /**
     * Test admin can update partner details.
     */
    public function test_admin_can_update_partner(): void
    {
        Storage::fake('public');

        $partner = Partner::create([
            'name' => 'Shopee Old',
            'logo_url' => 'partners/shopee-old.png'
        ]);

        $newLogo = UploadedFile::fake()->image('shopee-new.png');

        $response = $this->actingAs($this->admin)
            ->put(route('admin.partners.update', $partner), [
                'name' => 'Shopee',
                'logo' => $newLogo,
            ]);

        $response->assertRedirect(route('admin.partners.index'));
        $this->assertDatabaseHas('partners', [
            'id' => $partner->id,
            'name' => 'Shopee',
        ]);

        $partner->refresh();
        Storage::disk('public')->assertExists($partner->logo_url);
        Storage::disk('public')->assertMissing('partners/shopee-old.png');
    }

    /**
     * Test admin can delete partner.
     */
    public function test_admin_can_delete_partner(): void
    {
        Storage::fake('public');

        $partner = Partner::create([
            'name' => 'Bukalapak',
            'logo_url' => 'partners/bukalapak.png'
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.partners.destroy', $partner));

        $response->assertRedirect(route('admin.partners.index'));
        $this->assertDatabaseMissing('partners', [
            'id' => $partner->id,
        ]);
        Storage::disk('public')->assertMissing('partners/bukalapak.png');
    }
}
