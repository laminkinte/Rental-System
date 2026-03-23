<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLogin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'access_token',
        'refresh_token',
        'expires_at',
        'provider_data',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'provider_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
