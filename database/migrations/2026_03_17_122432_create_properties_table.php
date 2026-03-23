<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            
            // Property Type
            $table->enum('property_type', ['apartment', 'house', 'villa', 'cottage', 'studio', 'bungalow', 'entire_place', 'private_room', 'shared_room', 'unique_space', 'boutique_hotel', 'serviced_apartment']);
            $table->string('gambia_category')->nullable(); // beachfront_villa, eco_lodge, etc.
            
            // Location
            $table->string('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country')->default('Gambia');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('zip_code')->nullable();
            $table->string('location')->nullable(); // neighborhood description
            
            // Capacity
            $table->integer('guest_capacity');
            $table->integer('bedrooms');
            $table->integer('beds')->nullable();
            $table->integer('bathrooms');
            $table->decimal('size_sqm', 8, 2)->nullable();
            
            // Pricing
            $table->decimal('base_price', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->integer('weekly_discount')->default(0);
            $table->integer('monthly_discount')->default(0);
            $table->decimal('cleaning_fee', 10, 2)->default(0);
            $table->decimal('extra_guest_fee', 10, 2)->default(0);
            $table->decimal('security_deposit', 10, 2)->default(0);
            
            // Amenities - Individual columns for easier querying
            $table->boolean('running_water')->default(true);
            $table->boolean('electricity')->default(true);
            $table->boolean('wifi')->default(false);
            $table->boolean('air_conditioning')->default(false);
            $table->boolean('kitchen_access')->default(false);
            $table->boolean('parking')->default(false);
            $table->boolean('pool')->default(false);
            $table->boolean('terrace')->default(false);
            $table->boolean('garden')->default(false);
            $table->boolean('security_guard')->default(false);
            $table->boolean('cctv')->default(false);
            $table->boolean('hot_tub')->default(false);
            $table->boolean('bbq')->default(false);
            $table->boolean('beach_access')->default(false);
            $table->boolean('sea_view')->default(false);
            
            // JSON fields
            $table->json('images')->nullable();
            $table->json('amenities')->nullable();
            $table->json('pricing_rules')->nullable();
            $table->json('availability')->nullable();
            $table->json('rules')->nullable();
            
            // Availability Settings
            $table->integer('min_nights')->default(1);
            $table->integer('max_nights')->default(30);
            $table->time('check_in_time')->default('15:00');
            $table->time('check_out_time')->default('11:00');
            $table->boolean('instant_book')->default(false);
            $table->boolean('self_check_in')->default(false);
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('verified_listing')->default(false);
            $table->decimal('quality_score', 2, 1)->default(0);
            
            // House Rules
            $table->text('house_rules')->nullable();
            $table->string('cancellation_policy')->default('flexible');
            $table->string('pet_policy')->default('no_pets');
            $table->string('party_policy')->default('no_parties');
            $table->string('smoking_policy')->default('no_smoking');
            
            // Timestamps
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
