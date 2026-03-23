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
        Schema::create('group_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('guest_count');
            $table->decimal('total_amount', 12, 2);
            $table->json('members');
            $table->json('split_payment')->nullable();
            $table->enum('split_type', ['equal', 'custom', 'organizer_pays'])->default('equal');
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_bookings');
    }
};
