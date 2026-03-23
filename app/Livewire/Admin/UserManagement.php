<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserManagement extends Component
{
    use \Livewire\WithPagination;
    
    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    // Create/Edit Modal
    public $showModal = false;
    public $isEditing = false;
    public $editingUserId = null;
    
    // Form fields
    public $name = '';
    public $username = '';
    public $email = '';
    public $phone = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'user';
    public $is_host = false;
    public $is_verified = false;
    public $host_verified = false;
    
    // View user modal
    public $showViewModal = false;
    public $viewingUser = null;
    
    protected $paginationTheme = 'tailwind';
    
    public function render()
    {
        $query = User::query();
        
        // Apply filters
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('username', 'like', '%' . $this->search . '%');
            });
        }
        
        if ($this->roleFilter) {
            if ($this->roleFilter === 'admin') {
                $query->where('role', 'admin');
            } elseif ($this->roleFilter === 'host') {
                $query->where('is_host', true);
            } elseif ($this->roleFilter === 'user') {
                $query->where('role', '!=', 'admin')->where('is_host', false);
            }
        }
        
        if ($this->statusFilter === 'verified') {
            $query->where('is_verified', true);
        } elseif ($this->statusFilter === 'unverified') {
            $query->where('is_verified', false);
        }
        
        $users = $query->orderBy($this->sortField, $this->sortDirection)
                       ->paginate(15);
        
        return view('livewire.admin.user-management', [
            'users' => $users,
        ]);
    }
    
    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }
    
    public function openEditModal($userId)
    {
        $user = User::findOrFail($userId);
        $this->editingUserId = $userId;
        $this->isEditing = true;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->role = $user->role ?? 'user';
        $this->is_host = $user->is_host;
        $this->is_verified = $user->is_verified;
        $this->host_verified = $user->host_verified ?? false;
        $this->password = '';
        $this->password_confirmation = '';
        $this->showModal = true;
    }
    
    public function viewUser($userId)
    {
        $this->viewingUser = User::with(['properties', 'bookings'])->findOrFail($userId);
        $this->showViewModal = true;
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->showViewModal = false;
        $this->resetForm();
    }
    
    public function resetForm()
    {
        $this->name = '';
        $this->username = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = 'user';
        $this->is_host = false;
        $this->is_verified = false;
        $this->host_verified = false;
        $this->editingUserId = null;
    }
    
    public function saveUser()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username' . ($this->isEditing ? ',' . $this->editingUserId : ''),
            'email' => 'required|email|unique:users,email' . ($this->isEditing ? ',' . $this->editingUserId : ''),
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin',
            'is_host' => 'boolean',
            'is_verified' => 'boolean',
            'host_verified' => 'boolean',
        ];
        
        if (!$this->isEditing) {
            $rules['password'] = ['required', 'confirmed', Password::min(8)];
        } elseif ($this->password) {
            $rules['password'] = ['nullable', 'confirmed', Password::min(8)];
        }
        
        $this->validate($rules);
        
        $userData = [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'is_host' => $this->is_host,
            'is_verified' => $this->is_verified,
            'host_verified' => $this->is_host ? $this->host_verified : false,
        ];
        
        if ($this->password) {
            $userData['password'] = Hash::make($this->password);
        }
        
        if ($this->isEditing) {
            $user = User::findOrFail($this->editingUserId);
            $user->update($userData);
            session()->flash('success', 'User updated successfully!');
        } else {
            $user = User::create($userData);
            session()->flash('success', 'User created successfully!');
        }
        
        $this->closeModal();
    }
    
    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        
        // Prevent deleting yourself
        if ($user->id === Auth::id()) {
            session()->flash('error', 'You cannot delete your own account!');
            return;
        }
        
        // Prevent deleting the last admin
        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                session()->flash('error', 'Cannot delete the last admin user!');
                return;
            }
        }
        
        $user->delete();
        session()->flash('success', 'User deleted successfully!');
    }
    
    public function toggleVerification($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['is_verified' => !$user->is_verified]);
        session()->flash('success', 'User verification status updated!');
    }
    
    public function toggleHostVerification($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['host_verified' => !$user->host_verified]);
        session()->flash('success', 'Host verification status updated!');
    }
    
    public function toggleHostStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'is_host' => !$user->is_host,
            'host_verified' => !$user->is_host ? false : $user->host_verified
        ]);
        session()->flash('success', 'Host status updated!');
    }
    
    public function makeAdmin($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['role' => 'admin', 'is_host' => false, 'host_verified' => false]);
        session()->flash('success', 'User promoted to admin!');
    }
    
    public function removeAdmin($userId)
    {
        $user = User::findOrFail($userId);
        
        // Prevent removing yourself as admin
        if ($user->id === Auth::id()) {
            session()->flash('error', 'You cannot remove your own admin status!');
            return;
        }
        
        // Prevent removing the last admin
        $adminCount = User::where('role', 'admin')->count();
        if ($adminCount <= 1) {
            session()->flash('error', 'Cannot remove the last admin user!');
            return;
        }
        
        $user->update(['role' => 'user']);
        session()->flash('success', 'Admin status removed!');
    }
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function clearFilters()
    {
        $this->search = '';
        $this->roleFilter = '';
        $this->statusFilter = '';
    }
    
    public function toggleSuspension($userId)
    {
        $user = User::findOrFail($userId);
        
        // Prevent suspending yourself
        if ($user->id === Auth::id()) {
            session()->flash('error', 'You cannot suspend your own account!');
            return;
        }
        
        $newStatus = !$user->is_active;
        
        if ($newStatus) {
            // Unsuspend user
            $user->update([
                'is_active' => true,
                'suspension_reason' => null,
            ]);
            session()->flash('success', 'User has been unsuspended successfully!');
        } else {
            // Suspend user - show prompt for reason
            $user->update([
                'is_active' => false,
                'suspension_reason' => 'Suspended by administrator',
            ]);
            session()->flash('success', 'User has been suspended successfully!');
        }
    }
}
