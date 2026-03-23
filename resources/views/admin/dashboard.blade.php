<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
                        <span class="text-sm text-gray-500">JubbaStay Gambia Administration</span>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 p-6 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-2 bg-green-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Properties</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_properties']) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-purple-50 p-6 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-2 bg-purple-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m0 0l-2-2m2 2l2-2m2-6v6m0 0l2 2m-2-2l-2 2"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Bookings</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_bookings']) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 p-6 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-2 bg-yellow-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Reviews</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_reviews']) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <p class="text-lg font-bold text-green-600">{{ $stats['active_properties'] }}</p>
                            <p class="text-sm text-gray-600">Active Properties</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <p class="text-lg font-bold text-blue-600">{{ $stats['pending_bookings'] }}</p>
                            <p class="text-sm text-gray-600">Pending Bookings</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <p class="text-lg font-bold text-purple-600">{{ $stats['completed_bookings'] }}</p>
                            <p class="text-sm text-gray-600">Completed Bookings</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <p class="text-lg font-bold text-yellow-600">{{ $stats['verified_properties'] }}</p>
                            <p class="text-sm text-gray-600">Verified Properties</p>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <a href="{{ route('admin.users') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center transition-colors">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            Manage Users
                        </a>
                        <a href="{{ route('admin.properties') }}" class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg text-center transition-colors">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Manage Properties
                        </a>
                        <a href="{{ route('admin.bookings') }}" class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg text-center transition-colors">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m0 0l-2-2m2 2l2-2m2-6v6m0 0l2 2m-2-2l-2 2"/>
                            </svg>
                            Manage Bookings
                        </a>
                        <a href="{{ route('admin.reviews') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white p-4 rounded-lg text-center transition-colors">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            Manage Reviews
                        </a>
                    </div>

                    <!-- Recent Activity -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Recent Bookings -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Recent Bookings</h3>
                            <div class="space-y-3">
                                @forelse($recentBookings as $booking)
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium">{{ $booking->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $booking->property->title }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">No recent bookings</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Recent Properties -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Recent Properties</h3>
                            <div class="space-y-3">
                                @forelse($recentProperties as $property)
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium">{{ Str::limit($property->title, 20) }}</p>
                                            <p class="text-sm text-gray-600">by {{ $property->host->name }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($property->is_active) bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $property->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">No recent properties</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Recent Users -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Recent Users</h3>
                            <div class="space-y-3">
                                @forelse($recentUsers as $user)
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium">{{ $user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                        </div>
                                        <span class="text-xs text-gray-500">
                                            {{ $user->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">No recent users</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>