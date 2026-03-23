<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'booking_id',
        'reviewer_id',
        'reviewee_id',
        'type',
        'overall_rating',
        'comment',
        'ratings',
        'photos',
        'is_public',
    ];

    protected $casts = [
        'ratings' => 'array',
        'photos' => 'array',
        'is_public' => 'boolean',
        'overall_rating' => 'integer',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    public function scopeGuestToHost($query)
    {
        return $query->where('type', 'guest_to_host');
    }

    public function scopeHostToGuest($query)
    {
        return $query->where('type', 'host_to_guest');
    }
}
