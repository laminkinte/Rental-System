<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Extend users table for global platform features
        Schema::table('users', function (Blueprint $table) {
            // Phone authentication fields
            $table->string('phone_country_code', 10)->nullable()->after('phone');
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            $table->boolean('phone_auth_enabled')->default(true)->after('phone_verified_at');
            
            // Multi-profile system
            $table->enum('profile_type', ['guest', 'host', 'business', 'experience_provider', 'ambassador'])->default('guest')->after('role');
            $table->string('company_name')->nullable()->after('profile_type');
            $table->string('business_registration_number')->nullable()->after('company_name');
            $table->text('business_address')->nullable()->after('business_registration_number');
            $table->string('industry_type')->nullable()->after('business_address');
            $table->string('company_size')->nullable()->after('industry_type');
            $table->string('company_website')->nullable()->after('company_size');
            
            // Enhanced verification
            $table->enum('id_verification_level', ['none', 'basic', 'standard', 'enhanced', 'business', 'partner'])->default('none')->after('verification_level');
            $table->timestamp('id_verified_at')->nullable()->after('id_verification_level');
            $table->string('id_document_type')->nullable()->after('id_verified_at');
            $table->string('id_document_number')->nullable()->after('id_document_type');
            $table->string('id_document_front')->nullable()->after('id_document_number');
            $table->string('id_document_back')->nullable()->after('id_document_front');
            $table->string('selfie_image')->nullable()->after('id_document_back');
            $table->text('verification_notes')->nullable()->after('selfie_image');
            
            // Address verification
            $table->string('address_line1')->nullable()->after('country');
            $table->string('address_line2')->nullable()->after('address_line1');
            $table->string('state')->nullable()->after('address_line2');
            $table->string('postal_code')->nullable()->after('state');
            $table->string('city')->nullable()->after('postal_code');
            
            // Travel preferences
            $table->integer('typical_group_size')->nullable()->after('bio');
            $table->string('budget_range')->nullable()->after('typical_group_size'); // economy, mid-range, luxury
            $table->json('preferred_accommodation_types')->nullable()->after('budget_range');
            $table->string('travel_purpose')->nullable()->after('preferred_accommodation_types'); // leisure, business, relocation
            $table->json('accessibility_needs')->nullable()->after('travel_purpose');
            $table->json('pet_preferences')->nullable()->after('accessibility_needs');
            $table->json('dietary_restrictions')->nullable()->after('pet_preferences');
            $table->json('languages_spoken')->nullable()->after('dietary_restrictions');
            
            // Travel history stats
            $table->integer('total_bookings')->default(0)->after('languages_spoken');
            $table->integer('total_nights_stayed')->default(0)->after('total_bookings');
            $table->integer('countries_visited')->default(0)->after('total_nights_stayed');
            $table->integer('cities_visited')->default(0)->after('countries_visited');
            
            // Social features
            $table->integer('followers_count')->default(0)->after('cities_visited');
            $table->integer('following_count')->default(0)->after('followers_count');
            $table->integer('reviews_written_count')->default(0)->after('following_count');
            $table->json('badges')->nullable()->after('reviews_written_count');
            
            // Host-specific enhancements
            $table->integer('total_properties')->default(0)->after('badges');
            $table->decimal('average_rating', 3, 2)->default(0)->after('total_properties');
            $table->decimal('response_rate', 5, 2)->default(0)->after('average_rating');
            $table->integer('response_time_minutes')->default(0)->after('response_rate');
            $table->decimal('acceptance_rate', 5, 2)->default(0)->after('response_time_minutes');
            $table->decimal('lifetime_earnings', 12, 2)->default(0)->after('acceptance_rate');
            $table->timestamp('host_since')->nullable()->after('lifetime_earnings');
            $table->enum('host_level', ['new', 'experienced', 'super', 'elite'])->default('new')->after('host_since');
            
            // Financial
            $table->string('default_currency')->default('USD')->after('preferred_currency');
            $table->string('timezone')->default('UTC')->after('default_currency');
            $table->string('locale')->default('en')->after('timezone');
            
            // Privacy settings
            $table->enum('profile_visibility', ['public', 'members', 'connections', 'private'])->default('public')->after('locale');
            $table->boolean('show_online_status')->default(true)->after('profile_visibility');
            $table->boolean('show_last_seen')->default(true)->after('show_online_status');
            $table->boolean('read_receipts')->default(true)->after('show_last_seen');
            $table->boolean('marketing_emails')->default(true)->after('read_receipts');
            $table->boolean('third_party_sharing')->default(false)->after('marketing_emails');
            
            // Account security
            $table->boolean('two_factor_enabled')->default(false)->after('third_party_sharing');
            $table->string('two_factor_method')->nullable()->after('two_factor_enabled'); // sms, authenticator, biometric
            $table->text('two_factor_secret')->nullable()->after('two_factor_method');
            $table->json('login_history')->nullable()->after('two_factor_secret');
            $table->json('trusted_devices')->nullable()->after('login_history');
            
            // Referral system
            $table->string('referral_code')->unique()->nullable()->after('trusted_devices');
            $table->string('referred_by')->nullable()->after('referral_code');
            $table->integer('referral_count')->default(0)->after('referred_by');
            $table->decimal('referral_earnings', 10, 2)->default(0)->after('referral_count');
            
            // Loyalty program
            $table->integer('loyalty_points')->default(0)->after('referral_earnings');
            $table->enum('loyalty_tier', ['bronze', 'silver', 'gold', 'platinum'])->default('bronze')->after('loyalty_points');
            $table->timestamp('loyalty_tier_updated_at')->nullable()->after('loyalty_tier');
            
            // Marketing & tracking
            $table->string('utm_source')->nullable()->after('loyalty_tier_updated_at');
            $table->string('utm_medium')->nullable()->after('utm_source');
            $table->string('utm_campaign')->nullable()->after('utm_medium');
            $table->string('signup_ip', 45)->nullable()->after('utm_campaign');
            $table->string('current_ip', 45)->nullable()->after('signup_ip');
            
            // Account status enhancements
            $table->timestamp('suspended_at')->nullable()->after('current_ip');
            $table->string('suspension_reason')->nullable()->after('suspended_at');
            $table->timestamp('deleted_at')->nullable()->after('suspension_reason');
            
            // Social connections
            $table->string('social_google_id')->nullable()->after('deleted_at');
            $table->string('social_facebook_id')->nullable()->after('social_google_id');
            $table->string('social_apple_id')->nullable()->after('social_facebook_id');
            $table->string('social_twitter_id')->nullable()->after('social_apple_id');
            $table->string('social_linkedin_id')->nullable()->after('social_twitter_id');
            
            // Web3 (optional future)
            $table->string('wallet_address')->nullable()->after('social_linkedin_id');
            
            // Indexes
            $table->index('phone');
            $table->index('referral_code');
            $table->index('profile_type');
            $table->index(['profile_type', 'is_host']);
            $table->index('loyalty_tier');
        });

        // Create social logins table
        Schema::create('social_logins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('provider'); // google, facebook, apple, etc.
            $table->string('provider_id')->unique();
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->json('provider_data')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'provider']);
            $table->index('provider');
        });

        // Create connected accounts table for multi-account linking
        Schema::create('connected_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('account_type'); // email, phone, social
            $table->string('account_identifier'); // email address, phone number, social ID
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            
            $table->unique(['account_type', 'account_identifier']);
            $table->index('user_id');
        });

        // Create user sessions detail table
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('device_type')->nullable(); // mobile, tablet, desktop
            $table->string('device_name')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->boolean('is_current')->default(false);
            $table->timestamp('last_active_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            
            $table->index('user_id');
            $table->index('is_current');
        });

        // Create identity verifications table
        Schema::create('identity_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('verification_type', ['id', 'address', 'selfie', 'document'])->default('id');
            $table->enum('status', ['pending', 'submitted', 'processing', 'approved', 'rejected', 'expired'])->default('pending');
            $table->string('document_type')->nullable(); // passport, national_id, drivers_license
            $table->string('document_number')->nullable();
            $table->string('document_front_path')->nullable();
            $table->string('document_back_path')->nullable();
            $table->string('selfie_path')->nullable();
            $table->string('address_proof_path')->nullable();
            $table->string('rejection_reason')->nullable();
            $table->json('verification_data')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('identity_verifications');
        Schema::dropIfExists('user_sessions');
        Schema::dropIfExists('connected_accounts');
        Schema::dropIfExists('social_logins');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone_country_code', 'phone_verified_at', 'phone_auth_enabled',
                'profile_type', 'company_name', 'business_registration_number',
                'business_address', 'industry_type', 'company_size', 'company_website',
                'id_verification_level', 'id_verified_at', 'id_document_type',
                'id_document_number', 'id_document_front', 'id_document_back',
                'selfie_image', 'verification_notes',
                'address_line1', 'address_line2', 'state', 'postal_code', 'city',
                'typical_group_size', 'budget_range', 'preferred_accommodation_types',
                'travel_purpose', 'accessibility_needs', 'pet_preferences',
                'dietary_restrictions', 'languages_spoken',
                'total_bookings', 'total_nights_stayed', 'countries_visited', 'cities_visited',
                'followers_count', 'following_count', 'reviews_written_count', 'badges',
                'total_properties', 'average_rating', 'response_rate', 'response_time_minutes',
                'acceptance_rate', 'lifetime_earnings', 'host_since', 'host_level',
                'default_currency', 'timezone', 'locale',
                'profile_visibility', 'show_online_status', 'show_last_seen', 'read_receipts',
                'marketing_emails', 'third_party_sharing',
                'two_factor_enabled', 'two_factor_method', 'two_factor_secret',
                'login_history', 'trusted_devices',
                'referral_code', 'referred_by', 'referral_count', 'referral_earnings',
                'loyalty_points', 'loyalty_tier', 'loyalty_tier_updated_at',
                'utm_source', 'utm_medium', 'utm_campaign', 'signup_ip', 'current_ip',
                'suspended_at', 'suspension_reason', 'deleted_at',
                'social_google_id', 'social_facebook_id', 'social_apple_id',
                'social_twitter_id', 'social_linkedin_id', 'wallet_address'
            ]);
        });
    }
};
