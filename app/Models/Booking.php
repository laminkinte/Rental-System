<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'property_id',
        'user_id',
        'host_id',
        'check_in',
        'check_out',
        'nights',
        'guests',
        'adults',
        'children',
        'infants',
        'subtotal',
        'cleaning_fee',
        'service_fee',
        'taxes',
        'total_amount',
        'currency',
        'status',
        'payment_status',
        'payment_method',
        'payment_intent_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'special_requests',
        'cancelled_at',
        'cancelled_reason',
        'checked_in_at',
        'checked_out_at',
        'payment_details',
        'meta_data',
        'disputed',
        'dispute_resolution',
        'payout_status',
        'fraud_flagged',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'subtotal' => 'decimal:2',
        'cleaning_fee' => 'decimal:2',
        'service_fee' => 'decimal:2',
        'taxes' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_details' => 'array',
        'meta_data' => 'array',
        'cancelled_at' => 'datetime',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'guests' => 'integer',
        'adults' => 'integer',
        'children' => 'integer',
        'infants' => 'integer',
        'nights' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['cancelled']);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
    
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
