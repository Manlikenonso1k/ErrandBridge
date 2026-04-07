<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('wallet_address', 120)->nullable()->after('current_lng');
            $table->string('city_in_china', 120)->nullable()->after('wallet_address');
            $table->json('services_offered')->nullable()->after('city_in_china');
            $table->string('availability_hours', 120)->nullable()->after('services_offered');
            $table->json('languages')->nullable()->after('availability_hours');
            $table->boolean('notify_email')->default(true)->after('languages');
            $table->boolean('notify_push')->default(true)->after('notify_email');
            $table->enum('layout_density', ['compact', 'comfortable'])->default('comfortable')->after('notify_push');
            $table->string('language_preference', 10)->default('en')->after('layout_density');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn([
                'wallet_address',
                'city_in_china',
                'services_offered',
                'availability_hours',
                'languages',
                'notify_email',
                'notify_push',
                'layout_density',
                'language_preference',
            ]);
        });
    }
};
