<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_type',
        'device_name',
        'browser',
        'os',
        'ip_address',
        'country',
        'city',
        'is_current',
        'last_active_at',
        'expires_at',
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'last_active_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
