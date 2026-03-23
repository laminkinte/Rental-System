<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('nights')->default(1);
            $table->integer('guests');
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->integer('infants')->default(0);
            
            // Pricing breakdown
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('cleaning_fee', 10, 2)->default(0);
            $table->decimal('service_fee', 10, 2)->default(0);
            $table->decimal('taxes', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            
            // Status
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'refunded', 'failed'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_intent_id')->nullable();
            
            // Guest details
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('guest_phone')->nullable();
            
            // Special requests
            $table->text('special_requests')->nullable();
            
            // Cancellation
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancelled_reason')->nullable();
            
            // Check-in/out
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            
            // JSON
            $table->json('payment_details')->nullable();
            $table->json('meta_data')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
