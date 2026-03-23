<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'property_id',
        'notes',
        'added_at',
    ];

    protected $casts = [
        'added_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
