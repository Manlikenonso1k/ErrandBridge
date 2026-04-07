<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        Role::findOrCreate('admin', 'web');
        Role::findOrCreate('sender', 'web');
        Role::findOrCreate('runner', 'web');
        Role::findOrCreate('receiver', 'web');

        $admin = User::updateOrCreate(
            ['email' => 'admin@errandbridge.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['admin']);

        $sender = User::updateOrCreate(
            ['email' => 'sender@errandbridge.com'],
            [
                'name' => 'Sender Demo',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
        $sender->syncRoles(['sender']);

        $runner = User::updateOrCreate(
            ['email' => 'runner@errandbridge.com'],
            [
                'name' => 'Runner Demo',
                'password' => 'password',
                'email_verified_at' => now(),
                'is_available' => true,
                'current_lat' => 6.5244000,
                'current_lng' => 3.3792000,
            ]
        );
        $runner->syncRoles(['runner']);
    }
}
