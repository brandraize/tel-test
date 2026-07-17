<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_can_be_created_with_super_admin_access(): void
    {
        $user = User::create([
            'name' => 'admin1',
            'email' => 'admin1@example.com',
            'password' => bcrypt('password123'),
            'is_admin' => true,
            'role' => 'super_admin',
        ]);

        $this->assertTrue($user->is_admin);
        $this->assertTrue($user->hasRole('super_admin'));
        $this->assertTrue($user->hasPermission('dashboard.view'));
    }
}
