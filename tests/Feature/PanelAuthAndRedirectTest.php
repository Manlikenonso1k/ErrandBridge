<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PanelAuthAndRedirectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::findOrCreate('admin', 'web');
        Role::findOrCreate('sender', 'web');
        Role::findOrCreate('runner', 'web');
    }

    public function test_panel_login_and_registration_pages_are_available(): void
    {
        $this->get('/admin/login')->assertOk();
        $this->get('/sender/login')->assertOk();
        $this->get('/runner/login')->assertOk();
        $this->get('/sender/register')->assertOk();
        $this->get('/runner/register')->assertOk();
    }

    public function test_guest_is_redirected_from_dashboard_to_login_route(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_dashboard_redirects_admin_to_admin_panel(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertRedirect('/admin');
    }

    public function test_dashboard_redirects_sender_to_sender_panel(): void
    {
        $sender = User::factory()->create();
        $sender->assignRole('sender');

        $this->actingAs($sender)
            ->get('/dashboard')
            ->assertRedirect('/sender');
    }

    public function test_dashboard_redirects_runner_to_runner_panel(): void
    {
        $runner = User::factory()->create();
        $runner->assignRole('runner');

        $this->actingAs($runner)
            ->get('/dashboard')
            ->assertRedirect('/runner');
    }

    public function test_user_without_role_gets_forbidden_on_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertForbidden();
    }

    public function test_sender_cannot_access_admin_panel(): void
    {
        $sender = User::factory()->create();
        $sender->assignRole('sender');

        $this->actingAs($sender)
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_runner_cannot_access_sender_panel(): void
    {
        $runner = User::factory()->create();
        $runner->assignRole('runner');

        $this->actingAs($runner)
            ->get('/sender')
            ->assertForbidden();
    }

    public function test_roles_can_access_their_own_panels(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $this->actingAs($admin)->get('/admin')->assertOk();

        $sender = User::factory()->create();
        $sender->assignRole('sender');
        $this->actingAs($sender)->get('/sender')->assertOk();

        $runner = User::factory()->create();
        $runner->assignRole('runner');
        $this->actingAs($runner)->get('/runner')->assertOk();
    }
}
