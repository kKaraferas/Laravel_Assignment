<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // If a user is deleted, their reviews are deleted too
            $table->foreignId('video_game_id')->constrained()->onDelete('cascade'); // If a game is deleted, reviews go too
            $table->decimal('rating', 2, 1); // Rating from 0.0 to 5.0
            $table->text('review'); // Review text
            $table->timestamps();

            // Ensure a user can review a game only once
            $table->unique(['user_id', 'video_game_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
