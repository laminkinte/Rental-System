<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->enum('level', ['super_admin', 'admin', 'moderator', 'host', 'user'])->default('user');
            $table->boolean('is_system')->default(false); // System roles cannot be deleted
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Permissions table
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('module'); // e.g., 'users', 'properties', 'bookings', 'reports', 'settings'
            $table->string('description')->nullable();
            $table->enum('type', ['create', 'read', 'update', 'delete', 'manage'])->default('read');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Role-User pivot table (many-to-many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['role_id', 'user_id']);
        });

        // Permission-Role pivot table (many-to-many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->boolean('is_granted')->default(true);
            $table->timestamps();
            
            $table->unique(['permission_id', 'role_id']);
        });

        // User permissions (direct permissions, not through roles)
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->foreignId('granted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_granted')->default(true);
            $table->timestamp('granted_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'permission_id']);
        });

        // Admin access log
        Schema::create('admin_access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action'); // login, logout, view, create, update, delete
            $table->string('module'); // users, properties, bookings, etc.
            $table->string('resource_type')->nullable();
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_access_logs');
        Schema::dropIfExists('user_permissions');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
