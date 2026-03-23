<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('permission_role')->truncate();
        DB::table('role_user')->truncate();
        DB::table('user_permissions')->truncate();
        Permission::truncate();
        Role::truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create System Roles
        $this->createRoles();

        // Create Permissions
        $this->createPermissions();

        // Assign permissions to roles
        $this->assignPermissionsToRoles();
    }

    protected function createRoles()
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super_admin',
                'description' => 'Full system access - can manage everything',
                'level' => 'super_admin',
                'is_system' => true,
                'created_by' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrative access - can manage users, properties, bookings',
                'level' => 'admin',
                'is_system' => true,
                'created_by' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Moderator',
                'slug' => 'moderator',
                'description' => 'Moderation access - can manage content and disputes',
                'level' => 'moderator',
                'is_system' => true,
                'created_by' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Host',
                'slug' => 'host',
                'description' => 'Property host - can manage own properties and bookings',
                'level' => 'host',
                'is_system' => true,
                'created_by' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'Regular user - can browse and book properties',
                'level' => 'user',
                'is_system' => true,
                'created_by' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }

    protected function createPermissions()
    {
        $permissions = [
            // Users Module
            ['name' => 'View Users', 'slug' => 'users.read', 'module' => 'users', 'description' => 'View user list and details', 'type' => 'read'],
            ['name' => 'Create Users', 'slug' => 'users.create', 'module' => 'users', 'description' => 'Create new users', 'type' => 'create'],
            ['name' => 'Update Users', 'slug' => 'users.update', 'module' => 'users', 'description' => 'Update user details', 'type' => 'update'],
            ['name' => 'Delete Users', 'slug' => 'users.delete', 'module' => 'users', 'description' => 'Delete users', 'type' => 'delete'],
            ['name' => 'Manage Users', 'slug' => 'users.manage', 'module' => 'users', 'description' => 'Full user management access', 'type' => 'manage'],

            // Properties Module
            ['name' => 'View Properties', 'slug' => 'properties.read', 'module' => 'properties', 'description' => 'View property list and details', 'type' => 'read'],
            ['name' => 'Create Properties', 'slug' => 'properties.create', 'module' => 'properties', 'description' => 'Create new properties', 'type' => 'create'],
            ['name' => 'Update Properties', 'slug' => 'properties.update', 'module' => 'properties', 'description' => 'Update property details', 'type' => 'update'],
            ['name' => 'Delete Properties', 'slug' => 'properties.delete', 'module' => 'properties', 'description' => 'Delete properties', 'type' => 'delete'],
            ['name' => 'Manage Properties', 'slug' => 'properties.manage', 'module' => 'properties', 'description' => 'Full property management access', 'type' => 'manage'],

            // Bookings Module
            ['name' => 'View Bookings', 'slug' => 'bookings.read', 'module' => 'bookings', 'description' => 'View booking list and details', 'type' => 'read'],
            ['name' => 'Create Bookings', 'slug' => 'bookings.create', 'module' => 'bookings', 'description' => 'Create new bookings', 'type' => 'create'],
            ['name' => 'Update Bookings', 'slug' => 'bookings.update', 'module' => 'bookings', 'description' => 'Update booking details', 'type' => 'update'],
            ['name' => 'Cancel Bookings', 'slug' => 'bookings.cancel', 'module' => 'bookings', 'description' => 'Cancel bookings', 'type' => 'delete'],
            ['name' => 'Manage Bookings', 'slug' => 'bookings.manage', 'module' => 'bookings', 'description' => 'Full booking management access', 'type' => 'manage'],

            // Payments Module
            ['name' => 'View Payments', 'slug' => 'payments.read', 'module' => 'payments', 'description' => 'View payment list and details', 'type' => 'read'],
            ['name' => 'Process Payments', 'slug' => 'payments.process', 'module' => 'payments', 'description' => 'Process payments', 'type' => 'create'],
            ['name' => 'Refund Payments', 'slug' => 'payments.refund', 'module' => 'payments', 'description' => 'Refund payments', 'type' => 'update'],
            ['name' => 'Manage Payments', 'slug' => 'payments.manage', 'module' => 'payments', 'description' => 'Full payment management access', 'type' => 'manage'],

            // Payouts Module
            ['name' => 'View Payouts', 'slug' => 'payouts.read', 'module' => 'payouts', 'description' => 'View payout list', 'type' => 'read'],
            ['name' => 'Process Payouts', 'slug' => 'payouts.process', 'module' => 'payouts', 'description' => 'Process host payouts', 'type' => 'create'],
            ['name' => 'Manage Payouts', 'slug' => 'payouts.manage', 'module' => 'payouts', 'description' => 'Full payout management access', 'type' => 'manage'],

            // Reports Module
            ['name' => 'View Reports', 'slug' => 'reports.read', 'module' => 'reports', 'description' => 'View platform reports', 'type' => 'read'],
            ['name' => 'Manage Reports', 'slug' => 'reports.manage', 'module' => 'reports', 'description' => 'Full report management access', 'type' => 'manage'],

            // Analytics Module
            ['name' => 'View Analytics', 'slug' => 'analytics.read', 'module' => 'analytics', 'description' => 'View platform analytics', 'type' => 'read'],
            ['name' => 'Manage Analytics', 'slug' => 'analytics.manage', 'module' => 'analytics', 'description' => 'Full analytics access', 'type' => 'manage'],

            // Disputes Module
            ['name' => 'View Disputes', 'slug' => 'disputes.read', 'module' => 'disputes', 'description' => 'View dispute list', 'type' => 'read'],
            ['name' => 'Resolve Disputes', 'slug' => 'disputes.resolve', 'module' => 'disputes', 'description' => 'Resolve disputes', 'type' => 'update'],
            ['name' => 'Manage Disputes', 'slug' => 'disputes.manage', 'module' => 'disputes', 'description' => 'Full dispute management access', 'type' => 'manage'],

            // Messages Module
            ['name' => 'View Messages', 'slug' => 'messages.read', 'module' => 'messages', 'description' => 'View messages', 'type' => 'read'],
            ['name' => 'Send Messages', 'slug' => 'messages.send', 'module' => 'messages', 'description' => 'Send messages', 'type' => 'create'],
            ['name' => 'Manage Messages', 'slug' => 'messages.manage', 'module' => 'messages', 'description' => 'Full message management access', 'type' => 'manage'],

            // Reviews Module
            ['name' => 'View Reviews', 'slug' => 'reviews.read', 'module' => 'reviews', 'description' => 'View reviews', 'type' => 'read'],
            ['name' => 'Create Reviews', 'slug' => 'reviews.create', 'module' => 'reviews', 'description' => 'Create reviews', 'type' => 'create'],
            ['name' => 'Manage Reviews', 'slug' => 'reviews.manage', 'module' => 'reviews', 'description' => 'Full review management access', 'type' => 'manage'],

            // Settings Module
            ['name' => 'View Settings', 'slug' => 'settings.read', 'module' => 'settings', 'description' => 'View platform settings', 'type' => 'read'],
            ['name' => 'Update Settings', 'slug' => 'settings.update', 'module' => 'settings', 'description' => 'Update platform settings', 'type' => 'update'],
            ['name' => 'Manage Settings', 'slug' => 'settings.manage', 'module' => 'settings', 'description' => 'Full settings management access', 'type' => 'manage'],

            // Roles Module
            ['name' => 'View Roles', 'slug' => 'roles.read', 'module' => 'roles', 'description' => 'View roles', 'type' => 'read'],
            ['name' => 'Create Roles', 'slug' => 'roles.create', 'module' => 'roles', 'description' => 'Create roles', 'type' => 'create'],
            ['name' => 'Update Roles', 'slug' => 'roles.update', 'module' => 'roles', 'description' => 'Update roles', 'type' => 'update'],
            ['name' => 'Delete Roles', 'slug' => 'roles.delete', 'module' => 'roles', 'description' => 'Delete roles', 'type' => 'delete'],
            ['name' => 'Manage Roles', 'slug' => 'roles.manage', 'module' => 'roles', 'description' => 'Full role management access', 'type' => 'manage'],

            // Permissions Module
            ['name' => 'View Permissions', 'slug' => 'permissions.read', 'module' => 'permissions', 'description' => 'View permissions', 'type' => 'read'],
            ['name' => 'Manage Permissions', 'slug' => 'permissions.manage', 'module' => 'permissions', 'description' => 'Full permission management access', 'type' => 'manage'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }

    protected function assignPermissionsToRoles()
    {
        // Super Admin - gets ALL permissions
        $superAdmin = Role::where('slug', 'super_admin')->first();
        $allPermissions = Permission::all();
        $superAdmin->permissions()->attach($allPermissions->pluck('id')->toArray(), ['is_granted' => true]);

        // Admin - gets most permissions except roles/permissions management
        $admin = Role::where('slug', 'admin')->first();
        $adminPermissions = Permission::whereNotIn('module', ['roles', 'permissions'])
            ->orWhereIn('slug', ['roles.read', 'permissions.read'])
            ->get();
        $admin->permissions()->attach($adminPermissions->pluck('id')->toArray(), ['is_granted' => true]);

        // Moderator - gets read access and limited management
        $moderator = Role::where('slug', 'moderator')->first();
        $moderatorPermissions = Permission::whereIn('type', ['read'])
            ->orWhereIn('slug', [
                'properties.manage', 'bookings.manage', 'disputes.manage', 'reviews.manage', 'messages.manage'
            ])
            ->get();
        $moderator->permissions()->attach($moderatorPermissions->pluck('id')->toArray(), ['is_granted' => true]);

        // Host - gets own property and booking management
        $host = Role::where('slug', 'host')->first();
        $hostPermissions = Permission::whereIn('slug', [
            'properties.read', 'properties.create', 'properties.update',
            'bookings.read', 'bookings.update',
            'payouts.read', 'payouts.process',
            'reviews.read',
            'messages.read', 'messages.send',
            'analytics.read',
        ])->get();
        $host->permissions()->attach($hostPermissions->pluck('id')->toArray(), ['is_granted' => true]);

        // User - gets basic read access
        $user = Role::where('slug', 'user')->first();
        $userPermissions = Permission::whereIn('slug', [
            'properties.read',
            'bookings.read', 'bookings.create',
            'reviews.read', 'reviews.create',
            'messages.read', 'messages.send',
        ])->get();
        $user->permissions()->attach($userPermissions->pluck('id')->toArray(), ['is_granted' => true]);
    }
}
