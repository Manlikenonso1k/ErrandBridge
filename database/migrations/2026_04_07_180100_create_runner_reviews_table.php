<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('runner_reviews', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('errand_id')->constrained('errands')->cascadeOnDelete();
            $table->foreignId('runner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('stars');
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->unique(['errand_id', 'runner_id', 'sender_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('runner_reviews');
    }
};
