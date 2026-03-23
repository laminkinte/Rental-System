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
        Schema::table('profiles', function (Blueprint $table) {
            // Gambia-specific fields
            $table->string('nationality')->nullable();
            $table->json('languages_spoken')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('travel_style')->nullable();
            $table->json('dietary_requirements')->nullable();
            $table->json('accessibility_needs')->nullable();
            $table->json('communication_preferences')->nullable();
            $table->json('privacy_settings')->nullable();
            $table->json('notification_preferences')->nullable();

            // Host-specific fields
            $table->string('host_type')->nullable();
            $table->integer('years_experience')->nullable();
            $table->text('local_area_knowledge')->nullable();
            $table->json('special_skills')->nullable();
            $table->string('business_registration')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('tourism_license')->nullable();
            $table->text('insurance_details')->nullable();
            $table->string('bank_account')->nullable();
            $table->json('payout_methods')->nullable();
            $table->decimal('response_rate', 5, 2)->nullable();
            $table->integer('response_time')->nullable(); // in minutes
            $table->decimal('acceptance_rate', 5, 2)->nullable();
            $table->decimal('cancellation_rate', 5, 2)->nullable();
            $table->decimal('overall_rating', 3, 2)->nullable();
            $table->boolean('superhost_status')->default(false);
            $table->integer('years_hosting')->nullable();
            $table->integer('total_bookings')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'nationality', 'languages_spoken', 'emergency_contact', 'travel_style',
                'dietary_requirements', 'accessibility_needs', 'communication_preferences',
                'privacy_settings', 'notification_preferences', 'host_type', 'years_experience',
                'local_area_knowledge', 'special_skills', 'business_registration', 'tax_id',
                'tourism_license', 'insurance_details', 'bank_account', 'payout_methods',
                'response_rate', 'response_time', 'acceptance_rate', 'cancellation_rate',
                'overall_rating', 'superhost_status', 'years_hosting', 'total_bookings'
            ]);
        });
    }
};
