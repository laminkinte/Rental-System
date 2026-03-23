<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'host_id',
        'title',
        'description',
        'property_type',
        'gambia_category',
        'address',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'zip_code',
        'location',
        'guest_capacity',
        'bedrooms',
        'beds',
        'bathrooms',
        'size_sqm',
        'base_price',
        'currency',
        'weekly_discount',
        'monthly_discount',
        'cleaning_fee',
        'extra_guest_fee',
        'security_deposit',
        'running_water',
        'electricity',
        'wifi',
        'air_conditioning',
        'kitchen_access',
        'parking',
        'pool',
        'terrace',
        'garden',
        'security_guard',
        'cctv',
        'hot_tub',
        'bbq',
        'beach_access',
        'sea_view',
        'images',
        'amenities',
        'pricing_rules',
        'availability',
        'rules',
        'min_nights',
        'max_nights',
        'check_in_time',
        'check_out_time',
        'instant_book',
        'self_check_in',
        'is_active',
        'verified_listing',
        'quality_score',
        'house_rules',
        'cancellation_policy',
        'pet_policy',
        'party_policy',
        'smoking_policy',
    ];

    protected $casts = [
        'images' => 'array',
        'amenities' => 'array',
        'pricing_rules' => 'array',
        'availability' => 'array',
        'rules' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'base_price' => 'decimal:2',
        'size_sqm' => 'decimal:2',
        'cleaning_fee' => 'decimal:2',
        'extra_guest_fee' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'weekly_discount' => 'integer',
        'monthly_discount' => 'integer',
        'quality_score' => 'decimal:1',
        'min_nights' => 'integer',
        'max_nights' => 'integer',
        'running_water' => 'boolean',
        'electricity' => 'boolean',
        'wifi' => 'boolean',
        'air_conditioning' => 'boolean',
        'kitchen_access' => 'boolean',
        'parking' => 'boolean',
        'pool' => 'boolean',
        'terrace' => 'boolean',
        'garden' => 'boolean',
        'security_guard' => 'boolean',
        'cctv' => 'boolean',
        'hot_tub' => 'boolean',
        'bbq' => 'boolean',
        'beach_access' => 'boolean',
        'sea_view' => 'boolean',
        'instant_book' => 'boolean',
        'self_check_in' => 'boolean',
        'is_active' => 'boolean',
        'verified_listing' => 'boolean',
        'guest_capacity' => 'integer',
        'bedrooms' => 'integer',
        'beds' => 'integer',
        'bathrooms' => 'integer',
    ];

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    // Always return images as array
    public function getImagesAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }
        if (is_string($value) && $value) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }
}
