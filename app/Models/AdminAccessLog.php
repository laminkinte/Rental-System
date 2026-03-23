<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminAccessLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'module',
        'resource_type',
        'resource_id',
        'description',
        'metadata',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'metadata' => 'array',
        'resource_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeRecent($query, $limit = 50)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }
}
