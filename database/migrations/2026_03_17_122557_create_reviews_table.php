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
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reviewee_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['guest_to_host', 'host_to_guest', 'experience']);
            $table->integer('overall_rating')->min(1)->max(5);
            $table->text('comment')->nullable();
            $table->json('ratings')->nullable(); // cleanliness, communication, etc.
            $table->json('photos')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
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
