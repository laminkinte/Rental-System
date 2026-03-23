<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Admin Reports</h1>
                    <p class="text-gray-600 mt-1">Platform analytics and performance metrics</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="text-pink-600 hover:text-pink-700 font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                    <select wire:model.live="dateRange" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        <option value="7">Last 7 Days</option>
                        <option value="30">Last 30 Days</option>
                        <option value="90">Last 90 Days</option>
                        <option value="365">Last Year</option>
                        <option value="this_month">This Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="this_year">This Year</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>

                <!-- Custom Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" wire:model.live="startDate" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" wire:model.live="endDate" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                </div>

                <!-- Property Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Property</label>
                    <select wire:model.live="propertyFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        <option value="">All Properties</option>
                        @foreach($properties as $property)
                            <option value="{{ $property->id }}">{{ $property->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select wire:model.live="statusFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <!-- Role Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">User Role</label>
                    <select wire:model.live="roleFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        <option value="">All Roles</option>
                        <option value="host">Hosts</option>
                        <option value="guest">Guests</option>
                    </select>
                </div>

                <!-- Property Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
                    <select wire:model.live="typeFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        <option value="">All Types</option>
                        <option value="apartment">Apartment</option>
                        <option value="house">House</option>
                        <option value="villa">Villa</option>
                        <option value="studio">Studio</option>
                        <option value="cabin">Cabin</option>
                        <option value="cottage">Cottage</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4 pt-4 border-t">
                <button wire:click="clearFilters()" class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                    Clear Filters
                </button>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500">Filtered from {{ $startDate }} to {{ $endDate }}</span>
                </div>
            </div>
        </div>

        <!-- Report Type Tabs -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button wire:click="$set('reportType', 'overview')" 
                        class="px-6 py-3 text-sm font-medium {{ $reportType === 'overview' ? 'border-b-2 border-pink-500 text-pink-600' : 'text-gray-500 hover:text-gray-700' }}">
                        Overview
                    </button>
                    <button wire:click="$set('reportType', 'bookings')" 
                        class="px-6 py-3 text-sm font-medium {{ $reportType === 'bookings' ? 'border-b-2 border-pink-500 text-pink-600' : 'text-gray-500 hover:text-gray-700' }}">
                        Bookings
                    </button>
                    <button wire:click="$set('reportType', 'revenue')" 
                        class="px-6 py-3 text-sm font-medium {{ $reportType === 'revenue' ? 'border-b-2 border-pink-500 text-pink-600' : 'text-gray-500 hover:text-gray-700' }}">
                        Revenue
                    </button>
                    <button wire:click="$set('reportType', 'users')" 
                        class="px-6 py-3 text-sm font-medium {{ $reportType === 'users' ? 'border-b-2 border-pink-500 text-pink-600' : 'text-gray-500 hover:text-gray-700' }}">
                        Users
                    </button>
                    <button wire:click="$set('reportType', 'properties')" 
                        class="px-6 py-3 text-sm font-medium {{ $reportType === 'properties' ? 'border-b-2 border-pink-500 text-pink-600' : 'text-gray-500 hover:text-gray-700' }}">
                        Properties
                    </button>
                    <button wire:click="$set('reportType', 'hosts')" 
                        class="px-6 py-3 text-sm font-medium {{ $reportType === 'hosts' ? 'border-b-2 border-pink-500 text-pink-600' : 'text-gray-500 hover:text-gray-700' }}">
                        Hosts
                    </button>
                </nav>
            </div>

            <!-- Export Button -->
            <div class="p-4 flex justify-end">
                <button wire:click="exportExcel()" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-600 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Excel
                </button>
            </div>
        </div>

        <!-- Overview Stats -->
        @if($reportType === 'overview')
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500">Total Bookings</p>
                <p class="text-2xl font-bold text-gray-900">{{ $overviewStats['totalBookings'] ?? 0 }}</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500">Total Revenue</p>
                <p class="text-2xl font-bold text-gray-900">${{ number_format($overviewStats['totalRevenue'] ?? 0, 2) }}</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500">Total Users</p>
                <p class="text-2xl font-bold text-gray-900">{{ $overviewStats['totalUsers'] ?? 0 }}</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500">Total Properties</p>
                <p class="text-2xl font-bold text-gray-900">{{ $overviewStats['totalProperties'] ?? 0 }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500 mb-1">New Hosts</p>
                <p class="text-xl font-bold text-blue-600">{{ $overviewStats['newHosts'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500 mb-1">Average Rating</p>
                <p class="text-xl font-bold text-amber-600">{{ number_format($overviewStats['averageRating'] ?? 0, 1) }}/5</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500 mb-1">Cancellation Rate</p>
                <p class="text-xl font-bold text-red-600">{{ $overviewStats['cancellationRate'] ?? 0 }}%</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500 mb-1">Occupancy Rate</p>
                <p class="text-xl font-bold text-green-600">{{ $overviewStats['occupancyRate'] ?? 0 }}%</p>
            </div>
        </div>

        <!-- Top Properties & Hosts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Top Properties</h2>
                </div>
                <div class="p-6">
                    @forelse($topProperties as $property)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="font-medium text-gray-900">{{ $property->title }}</p>
                                <p class="text-sm text-gray-500">{{ $property->bookings_count ?? 0 }} bookings</p>
                            </div>
                            <p class="font-semibold text-green-600">${{ number_format($property->bookings_sum_total_amount ?? 0, 2) }}</p>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">No properties yet</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Top Hosts</h2>
                </div>
                <div class="p-6">
                    @forelse($topHosts as $host)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="font-medium text-gray-900">{{ $host->name }}</p>
                                <p class="text-sm text-gray-500">{{ $host->properties_count ?? 0 }} properties</p>
                            </div>
                            <p class="font-semibold text-green-600">${{ number_format($host->bookings_as_host_sum_total_amount ?? 0, 2) }}</p>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">No hosts yet</p>
                    @endforelse
                </div>
            </div>
        </div>
        @endif

        <!-- Report Preview Section -->
        @if($reportType !== 'overview' && $previewData)
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 capitalize">{{ $reportType }} Report Preview</h2>
                <span class="text-sm text-gray-500">{{ $previewData->total() }} total records</span>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                @if($reportType === 'bookings')
                                    <th class="pb-3">Guest</th>
                                    <th class="pb-3">Property</th>
                                    <th class="pb-3">Check In</th>
                                    <th class="pb-3">Check Out</th>
                                    <th class="pb-3">Amount</th>
                                    <th class="pb-3">Status</th>
                                @elseif($reportType === 'revenue')
                                    <th class="pb-3">Guest</th>
                                    <th class="pb-3">Property</th>
                                    <th class="pb-3">Amount</th>
                                    <th class="pb-3">Method</th>
                                    <th class="pb-3">Date</th>
                                @elseif($reportType === 'users')
                                    <th class="pb-3">Name</th>
                                    <th class="pb-3">Email</th>
                                    <th class="pb-3">Role</th>
                                    <th class="pb-3">Verified</th>
                                    <th class="pb-3">Joined</th>
                                @elseif($reportType === 'properties')
                                    <th class="pb-3">Title</th>
                                    <th class="pb-3">Type</th>
                                    <th class="pb-3">Host</th>
                                    <th class="pb-3">Price</th>
                                    <th class="pb-3">Status</th>
                                @elseif($reportType === 'hosts')
                                    <th class="pb-3">Name</th>
                                    <th class="pb-3">Email</th>
                                    <th class="pb-3">Properties</th>
                                    <th class="pb-3">Bookings</th>
                                    <th class="pb-3">Revenue</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($previewData as $item)
                                <tr class="hover:bg-gray-50">
                                    @if($reportType === 'bookings')
                                        <td class="py-3 text-sm text-gray-900">{{ $item->user->name ?? 'N/A' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->property->title ?? 'N/A' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->check_in ? \Carbon\Carbon::parse($item->check_in)->format('M j, Y') : 'N/A' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->check_out ? \Carbon\Carbon::parse($item->check_out)->format('M j, Y') : 'N/A' }}</td>
                                        <td class="py-3 text-sm font-semibold text-green-600">${{ number_format($item->total_amount ?? 0, 2) }}</td>
                                        <td class="py-3"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $item->status === 'confirmed' ? 'green' : ($item->status === 'cancelled' ? 'red' : 'gray') }}-100 text-{{ $item->status === 'confirmed' ? 'green' : ($item->status === 'cancelled' ? 'red' : 'gray') }}-800 capitalize">{{ $item->status ?? 'N/A' }}</span></td>
                                    @elseif($reportType === 'revenue')
                                        <td class="py-3 text-sm text-gray-900">{{ $item->booking?->user?->name ?? 'N/A' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->booking?->property?->title ?? 'N/A' }}</td>
                                        <td class="py-3 text-sm font-semibold text-green-600">${{ number_format($item->amount ?? 0, 2) }}</td>
                                        <td class="py-3 text-sm text-gray-600 capitalize">{{ $item->payment_method ?? 'N/A' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->created_at ? $item->created_at->format('M j, Y') : 'N/A' }}</td>
                                    @elseif($reportType === 'users')
                                        <td class="py-3 text-sm text-gray-900">{{ $item->name }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->email }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->is_host ? 'Host' : 'Guest' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->email_verified_at ? 'Yes' : 'No' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->created_at->format('M j, Y') }}</td>
                                    @elseif($reportType === 'properties')
                                        <td class="py-3 text-sm text-gray-900">{{ $item->title }}</td>
                                        <td class="py-3 text-sm text-gray-600 capitalize">{{ $item->property_type ?? 'N/A' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->host->name ?? 'N/A' }}</td>
                                        <td class="py-3 text-sm font-semibold text-green-600">${{ number_format($item->base_price ?? 0, 2) }}</td>
                                        <td class="py-3"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $item->is_active ? 'green' : 'red' }}-100 text-{{ $item->is_active ? 'green' : 'red' }}-800">{{ $item->is_active ? 'Active' : 'Inactive' }}</span></td>
                                    @elseif($reportType === 'hosts')
                                        <td class="py-3 text-sm text-gray-900">{{ $item->name }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->email }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->properties_count ?? 0 }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->bookings_as_host_count ?? 0 }}</td>
                                        <td class="py-3 text-sm font-semibold text-green-600">${{ number_format($item->bookings_as_host_sum_total_amount ?? 0, 2) }}</td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500">No data available for the selected filters</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $previewData->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
