<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Insert report-related permissions
        $permissions = [
            ['name' => 'view_admin_reports', 'slug' => 'view-admin-reports', 'module' => 'reports', 'display_name' => 'View Admin Reports', 'description' => 'Access to view platform-wide reports and analytics', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'export_admin_reports', 'slug' => 'export-admin-reports', 'module' => 'reports', 'display_name' => 'Export Admin Reports', 'description' => 'Export reports in various formats', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'view_financial_reports', 'slug' => 'view-financial-reports', 'module' => 'reports', 'display_name' => 'View Financial Reports', 'description' => 'Access to detailed financial reports', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'view_user_reports', 'slug' => 'view-user-reports', 'module' => 'reports', 'display_name' => 'View User Reports', 'description' => 'Access to user activity reports', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'view_property_reports', 'slug' => 'view-property-reports', 'module' => 'reports', 'display_name' => 'View Property Reports', 'description' => 'Access to property performance reports', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'view_host_reports', 'slug' => 'view-host-reports', 'module' => 'reports', 'display_name' => 'View Host Reports', 'description' => 'Access to host dashboard reports', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'export_host_reports', 'slug' => 'export-host-reports', 'module' => 'reports', 'display_name' => 'Export Host Reports', 'description' => 'Export host reports', 'created_at' => now(), 'updated_at' => now()],
        ];

        // Get the permission model to insert
        $permissionModel = app(\App\Models\Permission::class);
        
        foreach ($permissions as $permission) {
            $permissionModel::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        // Assign permissions to Super Admin role
        $superAdminRole = \App\Models\Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $superAdminRole->permissions()->syncWithoutDetaching(
                $permissionModel::whereIn('name', [
                    'view_admin_reports',
                    'export_admin_reports',
                    'view_financial_reports',
                    'view_user_reports',
                    'view_property_reports',
                ])->pluck('id')
            );
        }

        // Assign permissions to Host role
        $hostRole = \App\Models\Role::where('name', 'host')->first();
        if ($hostRole) {
            $hostRole->permissions()->syncWithoutDetaching(
                $permissionModel::whereIn('name', [
                    'view_host_reports',
                    'export_host_reports',
                ])->pluck('id')
            );
        }
    }

    public function down(): void
    {
        $permissionModel = app(\App\Models\Permission::class);
        $permissionModel::whereIn('name', [
            'view_admin_reports',
            'export_admin_reports',
            'view_financial_reports',
            'view_user_reports',
            'view_property_reports',
            'view_host_reports',
            'export_host_reports',
        ])->delete();
    }
};
