<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login view can be rendered.
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /**
     * Test successful login with correct admin credentials.
     */
    public function test_admin_can_login_with_correct_credentials(): void
    {
        $admin = User::forceCreate([
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'password' => bcrypt($password = 'password-test'),
            'role' => 'admin',
        ]);

        $response = $this->post(route('admin.login.post'), [
            'email' => $admin->email,
            'password' => $password,
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard'));
    }

    /**
     * Test login fails with incorrect password.
     */
    public function test_admin_cannot_login_with_incorrect_password(): void
    {
        $admin = User::forceCreate([
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'password' => bcrypt('password-test'),
            'role' => 'admin',
        ]);

        $response = $this->post(route('admin.login.post'), [
            'email' => $admin->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /**
     * Test logout functionality.
     */
    public function test_admin_can_logout(): void
    {
        $admin = User::forceCreate([
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'password' => bcrypt('password-test'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.logout'));

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
