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
        Schema::table('users', function (Blueprint $table) {
            // Verification fields
            if (!Schema::hasColumn('users', 'id_verification_status')) {
                $table->enum('id_verification_status', ['unverified', 'pending', 'approved', 'rejected'])
                    ->default('unverified')
                    ->after('password');
            }
            
            if (!Schema::hasColumn('users', 'id_verification_type')) {
                $table->string('id_verification_type')->nullable()->after('id_verification_status');
            }
            
            if (!Schema::hasColumn('users', 'id_verification_documents')) {
                $table->json('id_verification_documents')->nullable()->after('id_verification_type');
            }
            
            if (!Schema::hasColumn('users', 'phone_verified')) {
                $table->boolean('phone_verified')->default(false)->after('id_verification_documents');
            }

            // Host fields
            if (!Schema::hasColumn('users', 'superhost_status')) {
                $table->boolean('superhost_status')->default(false)->after('phone_verified');
            }
            
            if (!Schema::hasColumn('users', 'message_response_rate')) {
                $table->decimal('message_response_rate', 5, 2)->default(0)->after('superhost_status');
            }

            // Sustainability & compliance
            if (!Schema::hasColumn('users', 'sustainability_score')) {
                $table->integer('sustainability_score')->default(0)->after('message_response_rate');
            }
            
            if (!Schema::hasColumn('users', 'sustainability_details')) {
                $table->json('sustainability_details')->nullable()->after('sustainability_score');
            }

            // Community & impact
            if (!Schema::hasColumn('users', 'local_staff_count')) {
                $table->integer('local_staff_count')->default(0)->after('sustainability_details');
            }
            
            if (!Schema::hasColumn('users', 'sources_local_products')) {
                $table->boolean('sources_local_products')->default(false)->after('local_staff_count');
            }
            
            if (!Schema::hasColumn('users', 'local_partnerships')) {
                $table->integer('local_partnerships')->default(0)->after('sources_local_products');
            }

            // Carbon & environment
            if (!Schema::hasColumn('users', 'carbon_neutral_certified')) {
                $table->boolean('carbon_neutral_certified')->default(false)->after('local_partnerships');
            }
            
            if (!Schema::hasColumn('users', 'trees_planted')) {
                $table->integer('trees_planted')->default(0)->after('carbon_neutral_certified');
            }

            // Platform
            if (!Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->default(false)->after('trees_planted');
            }
            
            if (!Schema::hasColumn('users', 'banned')) {
                $table->boolean('banned')->default(false)->after('is_admin');
            }
            
            if (!Schema::hasColumn('users', 'ban_reason')) {
                $table->text('ban_reason')->nullable()->after('banned');
            }

            // Preferences
            if (!Schema::hasColumn('users', 'preferences')) {
                $table->json('preferences')->nullable()->after('ban_reason');
            }

            // Metadata
            if (!Schema::hasColumn('users', 'properties_count')) {
                $table->integer('properties_count')->default(0)->after('preferences');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'id_verification_status',
                'id_verification_type',
                'id_verification_documents',
                'phone_verified',
                'superhost_status',
                'message_response_rate',
                'sustainability_score',
                'sustainability_details',
                'local_staff_count',
                'sources_local_products',
                'local_partnerships',
                'carbon_neutral_certified',
                'trees_planted',
                'is_admin',
                'banned',
                'ban_reason',
                'preferences',
                'properties_count',
            ]);
        });
    }
};
