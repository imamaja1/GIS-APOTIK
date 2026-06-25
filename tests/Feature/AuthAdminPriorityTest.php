<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAdminPriorityTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_checks_admin_first_when_credentials_exist_in_both_tables(): void
    {
        $email = 'same@mail.test';
        $password = 'secret123';

        Admin::create([
            'nama_admin' => 'Admin Satu',
            'email' => $email,
            'password' => $password,
        ]);

        User::create([
            'nama_user' => 'User Satu',
            'email' => $email,
            'password' => $password,
        ]);

        $response = $this->post(route('login.post'), [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated('admin');
        $this->assertGuest('web');
    }

    public function test_login_redirects_to_user_dashboard_when_not_admin(): void
    {
        $email = 'user@mail.test';
        $password = 'secret123';

        User::create([
            'nama_user' => 'User Dua',
            'email' => $email,
            'password' => $password,
        ]);

        $response = $this->post(route('login.post'), [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertRedirect(route('user.dashboard'));
        $this->assertAuthenticated('web');
        $this->assertGuest('admin');
    }

    public function test_user_guard_cannot_access_admin_panel(): void
    {
        $user = User::create([
            'nama_user' => 'User Tiga',
            'email' => 'guard-user@mail.test',
            'password' => 'secret123',
        ]);

        $this->actingAs($user, 'web');

        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }
}
