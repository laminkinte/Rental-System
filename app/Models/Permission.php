<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'module',
        'description',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Module types
    public static $modules = [
        'users',
        'properties',
        'bookings',
        'payments',
        'reports',
        'settings',
        'messages',
        'reviews',
        'payouts',
        'disputes',
        'analytics',
        'roles',
        'permissions',
    ];

    // Permission types
    public static $types = [
        'create',
        'read',
        'update',
        'delete',
        'manage',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role')
            ->withPivot('is_granted')
            ->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_permissions')
            ->withPivot('granted_by', 'granted_at', 'expires_at', 'is_granted')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOfType($query, $module, $type)
    {
        return $query->where('module', $module)->where('type', $type);
    }
}
