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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('payment_method')->default('stripe'); // stripe, paypal, bank_transfer, mobile_money
            $table->string('payment_provider_id')->nullable(); // Stripe/PayPal transaction ID
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('GMD');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded', 'cancelled'])->default('pending');
            $table->json('payment_details')->nullable(); // Store payment method details, card info, etc.
            $table->timestamp('processed_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->boolean('is_refundable')->default(true);
            $table->decimal('refunded_amount', 10, 2)->default(0);
            $table->timestamps();

            $table->index(['booking_id']);
            $table->index(['user_id']);
            $table->index(['status']);
            $table->index(['payment_provider_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
