<?php

namespace Database\Seeders;

use App\Models\PlatformSetting;
use Illuminate\Database\Seeder;

class PlatformSettingsSeeder extends Seeder
{
    public function run(): void
    {
        PlatformSetting::updateOrCreate(
            ['key' => 'platform_fee_enabled'],
            ['value' => 'false', 'description' => 'Enable or disable platform fee on completed errands.']
        );

        PlatformSetting::updateOrCreate(
            ['key' => 'platform_fee_percentage'],
            ['value' => '5', 'description' => 'Percentage charged as the platform service fee.']
        );
    }
}