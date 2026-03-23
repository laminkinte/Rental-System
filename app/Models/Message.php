<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'booking_id',
        'property_id',
        'subject',
        'message',
        'message_type',
        'is_read',
        'read_at',
        'attachments',
        'is_archived',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_archived' => 'boolean',
        'read_at' => 'datetime',
        'attachments' => 'array',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeBetweenUsers($query, $userId1, $userId2)
    {
        return $query->where(function ($q) use ($userId1, $userId2) {
            $q->where(function ($qq) use ($userId1, $userId2) {
                $qq->where('sender_id', $userId1)->where('receiver_id', $userId2);
            })->orWhere(function ($qq) use ($userId1, $userId2) {
                $qq->where('sender_id', $userId2)->where('receiver_id', $userId1);
            });
        });
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('sender_id', $userId)->orWhere('receiver_id', $userId);
        });
    }

    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }
}
