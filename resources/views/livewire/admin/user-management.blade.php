<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                <p class="mt-1 text-sm text-gray-500">Manage all users, admins, and hosts on the platform</p>
            </div>
            <button wire:click="openCreateModal" class="px-4 py-2 bg-[#FF385C] text-white rounded-lg hover:bg-[#E2324A] transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New User
            </button>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, email, or username..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    </div>
                </div>
                
                <!-- Role Filter -->
                <select wire:model.live="roleFilter" class="px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    <option value="">All Roles</option>
                    <option value="admin">Admins</option>
                    <option value="host">Hosts</option>
                    <option value="user">Regular Users</option>
                </select>
                
                <!-- Status Filter -->
                <select wire:model.live="statusFilter" class="px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="verified">Verified</option>
                    <option value="unverified">Unverified</option>
                </select>
                
                <!-- Clear Filters -->
                <button wire:click="clearFilters" class="px-4 py-2 text-gray-600 hover:text-gray-900 border border-gray-200 rounded-lg hover:bg-gray-50">
                    Clear Filters
                </button>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('name')">
                            <div class="flex items-center gap-1">
                                User
                                @if($sortField === 'name')
                                    <svg class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('created_at')">
                            <div class="flex items-center gap-1">
                                Joined
                                @if($sortField === 'created_at')
                                    <svg class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($user->avatar)
                                        <img class="h-10 w-10 rounded-full" src="{{ $user->avatar }}" alt="">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-[#FF385C] to-[#00A699] flex items-center justify-center text-white font-semibold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->role === 'admin')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    Admin
                                </span>
                            @elseif($user->is_host)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Host
                                    @if($user->host_verified)
                                        ✓
                                    @endif
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    User
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                @if($user->is_verified)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Verified
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @endif
                                
                                @if(isset($user->is_active) && !$user->is_active)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Suspended
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="viewUser({{ $user->id }})" class="text-gray-400 hover:text-gray-600" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                <button wire:click="openEditModal({{ $user->id }})" class="text-gray-400 hover:text-blue-600" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                
                                <!-- Role Actions Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600" title="More Actions">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                                        @if($user->role !== 'admin')
                                            <button wire:click="makeAdmin({{ $user->id }})" class="block w-full text-left px-4 py-2 text-sm text-purple-600 hover:bg-gray-50">
                                                Make Admin
                                            </button>
                                        @else
                                            <button wire:click="removeAdmin({{ $user->id }})" class="block w-full text-left px-4 py-2 text-sm text-orange-600 hover:bg-gray-50">
                                                Remove Admin
                                            </button>
                                        @endif
                                        
                                        @if($user->role !== 'admin')
                                            <button wire:click="toggleHostStatus({{ $user->id }})" class="block w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-50">
                                                {{ $user->is_host ? 'Remove Host' : 'Make Host' }}
                                            </button>
                                        @endif
                                        
                                        <button wire:click="toggleVerification({{ $user->id }})" class="block w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-gray-50">
                                            {{ $user->is_verified ? 'Unverify' : 'Verify' }}
                                        </button>
                                        
                                        @if($user->is_host)
                                            <button wire:click="toggleHostVerification({{ $user->id }})" class="block w-full text-left px-4 py-2 text-sm text-teal-600 hover:bg-gray-50">
                                                {{ $user->host_verified ? 'Revoke Host Verification' : 'Verify Host' }}
                                            </button>
                                        @endif
                                        
                                        @if($user->id !== auth()->id())
                                            <button wire:click="toggleSuspension({{ $user->id }})" wire:confirm="Are you sure you want to {{ (isset($user->is_active) && $user->is_active) ? 'suspend' : 'unsuspend' }} this user?" class="block w-full text-left px-4 py-2 text-sm text-orange-600 hover:bg-gray-50">
                                                {{ (isset($user->is_active) && $user->is_active) ? 'Suspend User' : 'Unsuspend User' }}
                                            </button>
                                            
                                            <button wire:click="deleteUser({{ $user->id }})" wire:confirm="Are you sure you want to delete this user?" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                                                Delete User
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-400 text-5xl mb-4">👤</div>
                            <h3 class="text-lg font-medium text-gray-900">No users found</h3>
                            <p class="text-gray-500">Try adjusting your search or filters</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-init="$nextTick(() => show = true)">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeModal"></div>
            
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $isEditing ? 'Edit User' : 'Create New User' }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <form wire:submit="saveUser" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" wire:model="name" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent" required>
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Username *</label>
                                <input type="text" wire:model="username" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent" required>
                                @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" wire:model="email" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent" required>
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="text" wire:model="phone" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isEditing ? 'New Password (leave blank to keep)' : 'Password *' }}</label>
                                <input type="password" wire:model="password" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent" {{ !$isEditing ? 'required' : '' }}>
                                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                <input type="password" wire:model="password_confirmation" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
                                <select wire:model="role" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                                    <option value="user">Regular User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            
                            <div class="flex items-end gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model="is_host" class="w-4 h-4 text-[#FF385C] border-gray-300 rounded focus:ring-[#FF385C]">
                                    <span class="text-sm text-gray-700">Is Host</span>
                                </label>
                                
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model="is_verified" class="w-4 h-4 text-[#FF385C] border-gray-300 rounded focus:ring-[#FF385C]">
                                    <span class="text-sm text-gray-700">Verified</span>
                                </label>
                            </div>
                        </div>
                        
                        @if($is_host)
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="host_verified" class="w-4 h-4 text-[#FF385C] border-gray-300 rounded focus:ring-[#FF385C]">
                                <span class="text-sm text-gray-700">Host Verified</span>
                            </label>
                        </div>
                        @endif
                        
                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-[#FF385C] text-white rounded-lg hover:bg-[#E2324A]">
                                {{ $isEditing ? 'Update User' : 'Create User' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- View User Modal -->
    @if($showViewModal && $viewingUser)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeModal"></div>
            
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">User Details</h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex items-start gap-6">
                        <div class="flex-shrink-0">
                            @if($viewingUser->avatar)
                                <img class="h-20 w-20 rounded-full" src="{{ $viewingUser->avatar }}" alt="">
                            @else
                                <div class="h-20 w-20 rounded-full bg-gradient-to-br from-[#FF385C] to-[#00A699] flex items-center justify-center text-white text-2xl font-semibold">
                                    {{ substr($viewingUser->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h4 class="text-xl font-semibold text-gray-900">{{ $viewingUser->name }}</h4>
                            <p class="text-gray-500">{{ $viewingUser->email }}</p>
                            
                            <div class="flex items-center gap-4 mt-2">
                                @if($viewingUser->role === 'admin')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Admin</span>
                                @elseif($viewingUser->is_host)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Host</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">User</span>
                                @endif
                                
                                @if($viewingUser->is_verified)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Verified</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 grid grid-cols-3 gap-4 text-center">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $viewingUser->properties->count() }}</div>
                            <div class="text-sm text-gray-500">Properties</div>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $viewingUser->bookings->count() }}</div>
                            <div class="text-sm text-gray-500">Bookings</div>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $viewingUser->created_at->format('M Y') }}</div>
                            <div class="text-sm text-gray-500">Member Since</div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h5 class="text-sm font-medium text-gray-700 mb-2">Contact Information</h5>
                        <div class="space-y-2 text-sm">
                            @if($viewingUser->phone)
                                <p><span class="text-gray-500">Phone:</span> {{ $viewingUser->phone }}</p>
                            @endif
                            @if($viewingUser->country)
                                <p><span class="text-gray-500">Country:</span> {{ $viewingUser->country }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-6">
                        <button wire:click="closeModal" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Session Flash Messages -->
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
        @if(session()->has('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session()->has('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
        @endif
    </div>
</div>
