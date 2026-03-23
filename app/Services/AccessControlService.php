<?php

namespace App\Services;

use App\Models\AdminAccessLog;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccessControlService
{
    /**
     * Check if user has a specific permission
     */
    public function hasPermission(User $user, string $permissionSlug): bool
    {
        // Super admin has all permissions
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        // Check user's roles for the permission
        $roles = $user->roles()->wherePivot('is_active', true)->get();
        
        foreach ($roles as $role) {
            if ($role->hasPermission($permissionSlug)) {
                return true;
            }
        }

        // Check direct user permissions
        if ($this->hasDirectPermission($user, $permissionSlug)) {
            return true;
        }

        return false;
    }

    /**
     * Check if user has a specific permission through their roles
     */
    public function hasRolePermission(User $user, string $permissionSlug): bool
    {
        $roles = $user->roles()->wherePivot('is_active', true)->get();
        
        foreach ($roles as $role) {
            if ($role->hasPermission($permissionSlug)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has a direct permission (not through role)
     */
    public function hasDirectPermission(User $user, string $permissionSlug): bool
    {
        return $user->directPermissions()
            ->where('slug', $permissionSlug)
            ->wherePivot('is_granted', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->exists();
    }

    /**
     * Check if user is Super Admin
     */
    public function isSuperAdmin(User $user): bool
    {
        return $user->roles()
            ->where('level', 'super_admin')
            ->wherePivot('is_active', true)
            ->exists();
    }

    /**
     * Check if user is Admin (Super Admin or Admin)
     */
    public function isAdmin(User $user): bool
    {
        return $user->roles()
            ->whereIn('level', ['super_admin', 'admin'])
            ->wherePivot('is_active', true)
            ->exists();
    }

    /**
     * Check if user is Moderator
     */
    public function isModerator(User $user): bool
    {
        return $user->roles()
            ->whereIn('level', ['super_admin', 'admin', 'moderator'])
            ->wherePivot('is_active', true)
            ->exists();
    }

    /**
     * Check if user has access level
     */
    public function hasAccessLevel(User $user, string $requiredLevel): bool
    {
        $roles = $user->roles()->wherePivot('is_active', true)->get();
        
        foreach ($roles as $role) {
            if ($role->canAccessLevel($requiredLevel)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all permissions for a user (from roles + direct)
     */
    public function getAllPermissions(User $user): array
    {
        $permissions = [];

        // Get permissions from roles
        $roles = $user->roles()->wherePivot('is_active', true)->get();
        foreach ($roles as $role) {
            $rolePerms = $role->permissions()->wherePivot('is_granted', true)->get();
            foreach ($rolePerms as $perm) {
                $permissions[$perm->slug] = $perm;
            }
        }

        // Get direct permissions
        $directPerms = $user->directPermissions()
            ->wherePivot('is_granted', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->get();
        
        foreach ($directPerms as $perm) {
            $permissions[$perm->slug] = $perm;
        }

        return $permissions;
    }

    /**
     * Get user's role names
     */
    public function getRoleNames(User $user): array
    {
        return $user->roles()
            ->wherePivot('is_active', true)
            ->pluck('name')
            ->toArray();
    }

    /**
     * Get user's highest role level
     */
    public function getHighestRoleLevel(User $user): ?string
    {
        $level = $user->roles()
            ->wherePivot('is_active', true)
            ->orderByRaw("FIELD(level, 'super_admin', 'admin', 'moderator', 'host', 'user')")
            ->first();

        return $level ? $level->level : null;
    }

    /**
     * Assign role to user
     */
    public function assignRole(User $user, Role $role, ?User $assignedBy = null, ?\Carbon\Carbon $expiresAt = null, ?string $notes = null): bool
    {
        try {
            DB::table('role_user')->updateOrInsert(
                ['user_id' => $user->id, 'role_id' => $role->id],
                [
                    'assigned_by' => $assignedBy?->id,
                    'assigned_at' => now(),
                    'expires_at' => $expiresAt,
                    'is_active' => true,
                    'notes' => $notes,
                    'updated_at' => now(),
                ]
            );

            $this->logAccess($assignedBy ?? $user, 'assign_role', 'roles', Role::class, $role->id, "Assigned role {$role->name} to user {$user->name}");

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to assign role: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Revoke role from user
     */
    public function revokeRole(User $user, Role $role): bool
    {
        try {
            DB::table('role_user')
                ->where('user_id', $user->id)
                ->where('role_id', $role->id)
                ->update(['is_active' => false]);

            $this->logAccess(Auth::user(), 'revoke_role', 'roles', Role::class, $role->id, "Revoked role {$role->name} from user {$user->name}");

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to revoke role: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Grant permission directly to user
     */
    public function grantPermission(User $user, Permission $permission, ?User $grantedBy = null, ?\Carbon\Carbon $expiresAt = null): bool
    {
        try {
            DB::table('user_permissions')->updateOrInsert(
                ['user_id' => $user->id, 'permission_id' => $permission->id],
                [
                    'granted_by' => $grantedBy?->id,
                    'granted_at' => now(),
                    'expires_at' => $expiresAt,
                    'is_granted' => true,
                    'updated_at' => now(),
                ]
            );

            $this->logAccess($grantedBy ?? $user, 'grant_permission', 'permissions', Permission::class, $permission->id, "Granted permission {$permission->name} to user {$user->name}");

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to grant permission: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Revoke direct permission from user
     */
    public function revokePermission(User $user, Permission $permission): bool
    {
        try {
            DB::table('user_permissions')
                ->where('user_id', $user->id)
                ->where('permission_id', $permission->id)
                ->update(['is_granted' => false]);

            $this->logAccess(Auth::user(), 'revoke_permission', 'permissions', Permission::class, $permission->id, "Revoked permission {$permission->name} from user {$user->name}");

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to revoke permission: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if user can manage (CRUD) a specific module
     */
    public function canManage(User $user, string $module): bool
    {
        return $this->hasPermission($user, "{$module}.manage");
    }

    /**
     * Check if user can create in a module
     */
    public function canCreate(User $user, string $module): bool
    {
        return $this->hasPermission($user, "{$module}.create");
    }

    /**
     * Check if user can read in a module
     */
    public function canRead(User $user, string $module): bool
    {
        return $this->hasPermission($user, "{$module}.read");
    }

    /**
     * Check if user can update in a module
     */
    public function canUpdate(User $user, string $module): bool
    {
        return $this->hasPermission($user, "{$module}.update");
    }

    /**
     * Check if user can delete in a module
     */
    public function canDelete(User $user, string $module): bool
    {
        return $this->hasPermission($user, "{$module}.delete");
    }

    /**
     * Log admin access/action
     */
    public function logAccess(User $user, string $action, string $module, ?string $resourceType = null, ?int $resourceId = null, ?string $description = null): void
    {
        try {
            AdminAccessLog::create([
                'user_id' => $user->id,
                'action' => $action,
                'module' => $module,
                'resource_type' => $resourceType,
                'resource_id' => $resourceId,
                'description' => $description,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log access: ' . $e->getMessage());
        }
    }

    /**
     * Get access logs
     */
    public function getAccessLogs(?User $user = null, ?string $module = null, int $limit = 50)
    {
        $query = AdminAccessLog::with('user');
        
        if ($user) {
            $query->byUser($user->id);
        }
        
        if ($module) {
            $query->byModule($module);
        }

        return $query->recent($limit)->get();
    }
}
