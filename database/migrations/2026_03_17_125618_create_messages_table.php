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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->enum('message_type', ['inquiry', 'booking_request', 'general', 'system'])->default('general');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->json('attachments')->nullable(); // File attachments
            $table->boolean('is_archived')->default(false);
            $table->timestamps();

            $table->index(['sender_id', 'receiver_id']);
            $table->index(['booking_id']);
            $table->index(['property_id']);
            $table->index(['is_read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
