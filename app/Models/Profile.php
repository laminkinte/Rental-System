<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'first_name',
        'last_name',
        'phone',
        'date_of_birth',
        'bio',
        'profile_picture',
        'preferences',
        'verification_badges',
        'additional_data',
        // Gambia-specific fields
        'nationality',
        'languages_spoken',
        'emergency_contact',
        'travel_style',
        'dietary_requirements',
        'accessibility_needs',
        'communication_preferences',
        'privacy_settings',
        'notification_preferences',
        // Host-specific fields
        'host_type',
        'years_experience',
        'local_area_knowledge',
        'special_skills',
        'business_registration',
        'tax_id',
        'tourism_license',
        'insurance_details',
        'bank_account',
        'payout_methods',
        'response_rate',
        'response_time',
        'acceptance_rate',
        'cancellation_rate',
        'overall_rating',
        'superhost_status',
        'years_hosting',
        'total_bookings',
    ];

    protected $casts = [
        'preferences' => 'array',
        'verification_badges' => 'array',
        'additional_data' => 'array',
        'date_of_birth' => 'date',
        'languages_spoken' => 'array',
        'special_skills' => 'array',
        'payout_methods' => 'array',
        'notification_preferences' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
