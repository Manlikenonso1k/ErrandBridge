<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('runner_notification_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('runner_id')->constrained('users')->cascadeOnDelete();
            $table->string('channel', 20);
            $table->string('title');
            $table->text('body')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('runner_notification_logs');
    }
};
