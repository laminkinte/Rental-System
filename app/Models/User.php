<?php

namespace App\Models;

use App\Services\AccessControlService;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'role',
        'is_verified',
        'verification_level',
        'profile_completed',
        'preferred_language',
        'preferred_currency',
        'is_host',
        'host_verified',
        'superhost',
        'avatar',
        'bio',
        'country',
        'last_login_at',
        'is_active',
        'suspension_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'profile_completed' => 'boolean',
            'is_host' => 'boolean',
            'host_verified' => 'boolean',
            'superhost' => 'boolean',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'host_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get bookings where user is the host (property owner)
     */
    public function bookingsAsHost()
    {
        return $this->hasMany(Booking::class, 'host_id');
    }
    
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
    
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    public function isHost()
    {
        return $this->is_host === true;
    }

    // ==================== RBAC Relationships ====================

    /**
     * Roles assigned to the user
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')
            ->withPivot('assigned_by', 'assigned_at', 'expires_at', 'is_active', 'notes')
            ->withTimestamps();
    }

    /**
     * Direct permissions assigned to the user (not through roles)
     */
    public function directPermissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions')
            ->withPivot('granted_by', 'granted_at', 'expires_at', 'is_granted')
            ->withTimestamps();
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission(string $permissionSlug): bool
    {
        $accessControl = app(AccessControlService::class);
        return $accessControl->hasPermission($this, $permissionSlug);
    }

    /**
     * Check if user is Super Admin
     */
    public function isSuperAdmin(): bool
    {
        $accessControl = app(AccessControlService::class);
        return $accessControl->isSuperAdmin($this);
    }

    /**
     * Check if user is Admin (Super Admin or Admin)
     */
    public function isAdmin(): bool
    {
        $accessControl = app(AccessControlService::class);
        return $accessControl->isAdmin($this);
    }

    /**
     * Check if user is Moderator
     */
    public function isModerator(): bool
    {
        $accessControl = app(AccessControlService::class);
        return $accessControl->isModerator($this);
    }

    /**
     * Check if user has access level
     */
    public function hasAccessLevel(string $level): bool
    {
        $accessControl = app(AccessControlService::class);
        return $accessControl->hasAccessLevel($this, $level);
    }

    /**
     * Get all permissions for the user
     */
    public function getAllPermissions(): array
    {
        $accessControl = app(AccessControlService::class);
        return $accessControl->getAllPermissions($this);
    }

    /**
     * Get user's role names
     */
    public function getRoleNames(): array
    {
        $accessControl = app(AccessControlService::class);
        return $accessControl->getRoleNames($this);
    }

    /**
     * Get user's highest role level
     */
    public function getHighestRoleLevel(): ?string
    {
        $accessControl = app(AccessControlService::class);
        return $accessControl->getHighestRoleLevel($this);
    }

    /**
     * Check if user can manage a module
     */
    public function canManage(string $module): bool
    {
        return $this->hasPermission("{$module}.manage");
    }

    /**
     * Check if user can create in a module
     */
    public function canCreate(string $module): bool
    {
        return $this->hasPermission("{$module}.create");
    }

    /**
     * Check if user can read in a module
     */
    public function canRead(string $module): bool
    {
        return $this->hasPermission("{$module}.read");
    }

    /**
     * Check if user can update in a module
     */
    public function canUpdate(string $module): bool
    {
        return $this->hasPermission("{$module}.update");
    }

    /**
     * Check if user can delete in a module
     */
    public function canDelete(string $module): bool
    {
        return $this->hasPermission("{$module}.delete");
    }

    /**
     * Scope to get only admin users
     */
    public function scopeAdmins($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->whereIn('level', ['super_admin', 'admin', 'moderator']);
        });
    }

    /**
     * Scope to get only hosts
     */
    public function scopeHosts($query)
    {
        return $query->where('is_host', true);
    }

    /**
     * Get admin access logs for this user
     */
    public function adminAccessLogs()
    {
        return $this->hasMany(AdminAccessLog::class);
    }
}
