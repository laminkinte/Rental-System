<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'balance',
        'currency',
        'tier',
        'transaction_history',
        'payment_methods',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'transaction_history' => 'array',
        'payment_methods' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
