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
        Schema::table('properties', function (Blueprint $table) {
            // Energy features
            if (!Schema::hasColumn('properties', 'has_solar_panels')) {
                $table->boolean('has_solar_panels')->default(false)->after('description');
            }
            
            if (!Schema::hasColumn('properties', 'has_wind_power')) {
                $table->boolean('has_wind_power')->default(false)->after('has_solar_panels');
            }
            
            if (!Schema::hasColumn('properties', 'energy_star_appliances')) {
                $table->boolean('energy_star_appliances')->default(false)->after('has_wind_power');
            }
            
            if (!Schema::hasColumn('properties', 'led_lighting_percentage')) {
                $table->integer('led_lighting_percentage')->default(0)->after('energy_star_appliances');
            }
            
            if (!Schema::hasColumn('properties', 'smart_thermostat')) {
                $table->boolean('smart_thermostat')->default(false)->after('led_lighting_percentage');
            }

            // Water features
            if (!Schema::hasColumn('properties', 'low_flow_showers')) {
                $table->boolean('low_flow_showers')->default(false)->after('smart_thermostat');
            }
            
            if (!Schema::hasColumn('properties', 'low_flow_toilets')) {
                $table->boolean('low_flow_toilets')->default(false)->after('low_flow_showers');
            }
            
            if (!Schema::hasColumn('properties', 'rainwater_harvesting')) {
                $table->boolean('rainwater_harvesting')->default(false)->after('low_flow_toilets');
            }
            
            if (!Schema::hasColumn('properties', 'native_plants_landscaping')) {
                $table->boolean('native_plants_landscaping')->default(false)->after('rainwater_harvesting');
            }

            // Waste features
            if (!Schema::hasColumn('properties', 'recycling_available')) {
                $table->boolean('recycling_available')->default(false)->after('native_plants_landscaping');
            }
            
            if (!Schema::hasColumn('properties', 'composting_available')) {
                $table->boolean('composting_available')->default(false)->after('recycling_available');
            }
            
            if (!Schema::hasColumn('properties', 'no_single_use_plastics')) {
                $table->boolean('no_single_use_plastics')->default(false)->after('composting_available');
            }
            
            if (!Schema::hasColumn('properties', 'eco_toiletries_only')) {
                $table->boolean('eco_toiletries_only')->default(false)->after('no_single_use_plastics');
            }

            // Transport & walkability
            if (!Schema::hasColumn('properties', 'ev_charging_available')) {
                $table->boolean('ev_charging_available')->default(false)->after('eco_toiletries_only');
            }
            
            if (!Schema::hasColumn('properties', 'bike_parking_available')) {
                $table->boolean('bike_parking_available')->default(false)->after('ev_charging_available');
            }
            
            if (!Schema::hasColumn('properties', 'transit_score')) {
                $table->integer('transit_score')->default(50)->after('bike_parking_available');
            }
            
            if (!Schema::hasColumn('properties', 'walkable_score')) {
                $table->integer('walkable_score')->default(50)->after('transit_score');
            }

            // Verification & compliance
            if (!Schema::hasColumn('properties', 'suspension_reason')) {
                $table->text('suspension_reason')->nullable()->after('walkable_score');
            }
            
            if (!Schema::hasColumn('properties', 'payout_status')) {
                $table->enum('payout_status', ['pending', 'approved', 'processing', 'completed'])->default('pending')->after('suspension_reason');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'has_solar_panels',
                'has_wind_power',
                'energy_star_appliances',
                'led_lighting_percentage',
                'smart_thermostat',
                'low_flow_showers',
                'low_flow_toilets',
                'rainwater_harvesting',
                'native_plants_landscaping',
                'recycling_available',
                'composting_available',
                'no_single_use_plastics',
                'eco_toiletries_only',
                'ev_charging_available',
                'bike_parking_available',
                'transit_score',
                'walkable_score',
                'suspension_reason',
                'payout_status',
            ]);
        });
    }
};
