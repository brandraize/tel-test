<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateDefaultAdminUser extends Command
{
    protected $signature = 'admin:create-default';
    protected $description = 'Create the default admin account for the requested credentials';

    public function handle(): int
    {
        $email = 'admin1';
        $password = 'password123';

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin User',
                'password' => Hash::make($password),
                'is_admin' => true,
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        if (!$user->wasRecentlyCreated) {
            $user->forceFill([
                'password' => Hash::make($password),
                'is_admin' => true,
                'role' => 'super_admin',
            ])->save();
        }

        $this->info('Default admin account ready.');
        $this->info("Email: {$email}");
        $this->info('Password: password123');

        return self::SUCCESS;
    }
}
