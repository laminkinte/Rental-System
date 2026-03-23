<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'payment_method',
        'payment_provider_id',
        'amount',
        'currency',
        'status',
        'payment_details',
        'processed_at',
        'failure_reason',
        'is_refundable',
        'refunded_amount',
        'fraud_score',
        'fraud_flagged',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'refunded_amount' => 'decimal:2',
        'payment_details' => 'array',
        'processed_at' => 'datetime',
        'is_refundable' => 'boolean',
        'fraud_score' => 'array',
        'fraud_flagged' => 'boolean',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function markAsCompleted($providerId = null)
    {
        $this->update([
            'status' => 'completed',
            'payment_provider_id' => $providerId,
            'processed_at' => now(),
        ]);
    }

    public function markAsFailed($reason = null)
    {
        $this->update([
            'status' => 'failed',
            'failure_reason' => $reason,
        ]);
    }

    public function canRefund()
    {
        return $this->is_refundable &&
               $this->status === 'completed' &&
               $this->refunded_amount < $this->amount;
    }
}
