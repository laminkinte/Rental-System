<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    protected $casts = [
        'value' => 'array',
    ];

    // Get setting value
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    // Set setting value
    public static function set($key, $value, $type = 'string', $group = 'general')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group]
        );
    }

    // Get all settings by group
    public static function getGroup($group)
    {
        return static::where('group', $group)->pluck('value', 'key');
    }

    // Default settings
    public static function defaults()
    {
        return [
            // General
            'site_name' => ['Connect & Stay', 'string', 'general'],
            'tagline' => ['Connect & Stay - Global Hospitality Platform', 'string', 'general'],
            'description' => ['A revolutionary peer-to-peer accommodation platform with global reach', 'string', 'general'],
            'email' => ['support@connectandstay.com', 'string', 'general'],
            'phone' => ['+1-800-CONNECT', 'string', 'general'],
            'address' => ['Global Headquarters', 'string', 'general'],
            'city' => ['New York', 'string', 'general'],
            'country' => ['United States', 'string', 'general'],
            
            // Branding
            'logo_url' => ['/images/logo.png', 'string', 'branding'],
            'favicon_url' => ['/favicon.ico', 'string', 'branding'],
            'primary_color' => ['#FF385C', 'string', 'branding'],
            'secondary_color' => ['#00A699', 'string', 'branding'],
            'accent_color' => ['#FF5A5F', 'string', 'branding'],
            
            // Currency & Locale
            'currency' => ['USD', 'string', 'locale'],
            'currency_symbol' => ['$', 'string', 'locale'],
            'currency_position' => ['before', 'string', 'locale'],
            'date_format' => ['M d, Y', 'string', 'locale'],
            'time_format' => ['h:i A', 'string', 'locale'],
            'timezone' => ['UTC', 'string', 'locale'],
            'language' => ['en', 'string', 'locale'],
            
            // Booking
            'min_booking_amount' => [10, 'number', 'booking'],
            'max_booking_amount' => [10000, 'number', 'booking'],
            'min_guests' => [1, 'number', 'booking'],
            'max_guests' => [20, 'number', 'booking'],
            'default_check_in' => ['15:00', 'string', 'booking'],
            'default_check_out' => ['11:00', 'string', 'booking'],
            
            // Fees
            'service_fee_percent' => [5, 'number', 'fees'],
            'host_fee_percent' => [3, 'number', 'fees'],
            'payment_processing_fee' => [2.9, 'number', 'fees'],
            
            // Social Links
            'facebook_url' => ['https://facebook.com', 'string', 'social'],
            'twitter_url' => ['https://twitter.com', 'string', 'social'],
            'instagram_url' => ['https://instagram.com', 'string', 'social'],
            'linkedin_url' => ['https://linkedin.com', 'string', 'social'],
            'youtube_url' => ['https://youtube.com', 'string', 'social'],
            
            // SEO
            'meta_title' => ['Connect & Stay - Book Unique Accommodations', 'string', 'seo'],
            'meta_description' => ['Find and book unique accommodations worldwide. Connect with local hosts and experience authentic travel.', 'string', 'seo'],
            'meta_keywords' => ['vacation rental, accommodations, travel, hosting', 'string', 'seo'],
        ];
    }
}
