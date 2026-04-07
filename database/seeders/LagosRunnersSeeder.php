<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class LagosRunnersSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 5) as $index) {
            $runner = User::updateOrCreate(
                ['email' => "lagos.runner{$index}@errandbridge.com"],
                [
                    'name' => "Lagos Runner {$index}",
                    'password' => 'password',
                    'email_verified_at' => now(),
                    'is_available' => true,
                    'current_lat' => fake()->randomFloat(7, 6.4300000, 6.7000000),
                    'current_lng' => fake()->randomFloat(7, 3.2000000, 3.5500000),
                ]
            );

            $runner->syncRoles(['runner']);
        }
    }
}
