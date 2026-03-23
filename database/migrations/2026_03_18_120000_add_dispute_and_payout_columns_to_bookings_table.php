<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Dispute-related columns
            $table->boolean('disputed')->default(false)->after('status');
            $table->string('dispute_reason')->nullable()->after('disputed');
            $table->string('dispute_resolution')->nullable()->after('dispute_reason');
            $table->timestamp('disputed_at')->nullable()->after('dispute_resolution');

            // Payout-related columns
            $table->string('payout_status')->default('pending')->after('disputed_at'); // pending, approved, paid
            $table->decimal('payout_amount', 10, 2)->nullable()->after('payout_status');
            $table->timestamp('payout_processed_at')->nullable()->after('payout_amount');

            // Host reference (for payouts)
            $table->foreignId('host_id')->nullable()->constrained('users')->onDelete('set null')->after('user_id');

            // Additional payment status tracking
            $table->timestamp('confirmed_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['host_id']);
            $table->dropColumn([
                'disputed',
                'dispute_reason',
                'dispute_resolution',
                'disputed_at',
                'payout_status',
                'payout_amount',
                'payout_processed_at',
                'host_id',
                'confirmed_at',
            ]);
        });
    }
};
