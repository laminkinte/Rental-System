<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'level',
        'is_system',
        'created_by',
        'is_active',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Role level hierarchy (higher number = more power)
    public static $levels = [
        'super_admin' => 100,
        'admin' => 80,
        'moderator' => 60,
        'host' => 40,
        'user' => 20,
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user')
            ->withPivot('assigned_by', 'assigned_at', 'expires_at', 'is_active', 'notes')
            ->withTimestamps();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role')
            ->withPivot('is_granted')
            ->withTimestamps();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function hasPermission(string $permissionSlug): bool
    {
        // Direct permission check on role
        if ($this->permissions()->where('slug', $permissionSlug)->wherePivot('is_granted', true)->exists()) {
            return true;
        }

        // Check for 'manage' permission (grants all other permissions in module)
        $permission = Permission::where('slug', $permissionSlug)->first();
        if ($permission) {
            $managePermission = $this->permissions()
                ->where('module', $permission->module)
                ->where('type', 'manage')
                ->wherePivot('is_granted', true)
                ->exists();
            
            if ($managePermission) {
                return true;
            }
        }

        return false;
    }

    public function canAccessLevel(string $requiredLevel): bool
    {
        $userLevel = self::$levels[$this->level] ?? 0;
        $requiredLevelValue = self::$levels[$requiredLevel] ?? 0;
        
        return $userLevel >= $requiredLevelValue;
    }

    public function isSuperAdmin(): bool
    {
        return $this->level === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->level, ['super_admin', 'admin']);
    }
}
