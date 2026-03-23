<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Host Reports</h1>
                    <p class="text-gray-600 mt-1">Track your performance and earnings</p>
                </div>
                <a href="{{ route('host.dashboard') }}" class="text-pink-600 hover:text-pink-700 font-medium flex items-center gap-2">
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

                <!-- Start Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" wire:model.live="startDate" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                </div>

                <!-- End Date -->
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Booking Status</label>
                    <select wire:model.live="statusFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <!-- Payout Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payout Status</label>
                    <select wire:model.live="payoutStatusFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        <option value="">All Payouts</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="paid">Paid</option>
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
                    <button wire:click="$set('reportType', 'reviews')" 
                        class="px-6 py-3 text-sm font-medium {{ $reportType === 'reviews' ? 'border-b-2 border-pink-500 text-pink-600' : 'text-gray-500 hover:text-gray-700' }}">
                        Reviews
                    </button>
                    <button wire:click="$set('reportType', 'payouts')" 
                        class="px-6 py-3 text-sm font-medium {{ $reportType === 'payouts' ? 'border-b-2 border-pink-500 text-pink-600' : 'text-gray-500 hover:text-gray-700' }}">
                        Payouts
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
                        <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500">Average Rating</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($overviewStats['averageRating'] ?? 0, 1) }}/5</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500">Properties</p>
                <p class="text-2xl font-bold text-gray-900">{{ $overviewStats['totalProperties'] ?? 0 }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500 mb-1">Confirmed Bookings</p>
                <p class="text-xl font-bold text-green-600">{{ $overviewStats['confirmedBookings'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500 mb-1">Pending Payouts</p>
                <p class="text-xl font-bold text-amber-600">${{ number_format($overviewStats['pendingPayouts'] ?? 0, 2) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500 mb-1">Cancellation Rate</p>
                <p class="text-xl font-bold text-red-600">{{ $overviewStats['cancellationRate'] ?? 0 }}%</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500 mb-1">Occupancy Rate</p>
                <p class="text-xl font-bold text-blue-600">{{ $overviewStats['occupancyRate'] ?? 0 }}%</p>
            </div>
        </div>

        <!-- Revenue by Property -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Revenue by Property</h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <th class="pb-3">Property</th>
                                <th class="pb-3">Bookings</th>
                                <th class="pb-3">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($revenueByProperty as $property)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 font-medium text-gray-900">{{ $property->title }}</td>
                                    <td class="py-3 text-gray-600">{{ $property->bookings_count ?? 0 }}</td>
                                    <td class="py-3 font-semibold text-green-600">${{ number_format($property->bookings_sum_total_amount ?? 0, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-gray-500">No properties yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Upcoming Bookings & Recent Reviews -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Upcoming Bookings -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Upcoming Bookings</h2>
                </div>
                <div class="p-6">
                    @forelse($upcomingBookings as $booking)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="font-medium text-gray-900">{{ $booking->user->name ?? 'Guest' }}</p>
                                <p class="text-sm text-gray-500">{{ $booking->property->title ?? 'Property' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">{{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('M j') : '' }}</p>
                                <p class="text-sm font-semibold text-gray-900">${{ number_format($booking->total_amount ?? 0, 2) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">No upcoming bookings</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Reviews -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Reviews</h2>
                </div>
                <div class="p-6">
                    @forelse($recentReviews as $review)
                        <div class="py-3 border-b border-gray-100 last:border-0">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="flex text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= ($review->overall_rating ?? 0) ? 'text-amber-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500">{{ $review->created_at ? $review->created_at->diffForHumans() : '' }}</span>
                            </div>
                            <p class="text-sm text-gray-600">{{ $review->comment ?? 'No comment' }}</p>
                            <p class="text-xs text-gray-400 mt-1">- {{ $review->reviewer->name ?? 'Anonymous' }}</p>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">No reviews yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Payout History -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Payout History</h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <th class="pb-3">Date</th>
                                <th class="pb-3">Property</th>
                                <th class="pb-3">Booking</th>
                                <th class="pb-3">Amount</th>
                                <th class="pb-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($payoutHistory as $payout)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 text-sm text-gray-600">{{ $payout->created_at ? \Carbon\Carbon::parse($payout->created_at)->format('M j, Y') : '' }}</td>
                                    <td class="py-3 text-sm text-gray-900">{{ $payout->property->title ?? 'Property' }}</td>
                                    <td class="py-3 text-sm text-gray-600">#{{ $payout->id }}</td>
                                    <td class="py-3 text-sm font-semibold text-green-600">${{ number_format($payout->total_amount ?? 0, 2) }}</td>
                                    <td class="py-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $payout->payout_status === 'paid' ? 'green' : ($payout->payout_status === 'approved' ? 'blue' : 'yellow') }}-100 text-{{ $payout->payout_status === 'paid' ? 'green' : ($payout->payout_status === 'approved' ? 'blue' : 'yellow') }}-800 capitalize">
                                            {{ $payout->payout_status ?? 'pending' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500">No payout history</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Report Preview Section -->
        @if($reportType !== 'overview' && $previewData && is_object($previewData) && method_exists($previewData, 'total'))
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
                                    <th class="pb-3">Property</th>
                                    <th class="pb-3">Location</th>
                                    <th class="pb-3">Bookings</th>
                                    <th class="pb-3">Revenue</th>
                                @elseif($reportType === 'reviews')
                                    <th class="pb-3">Guest</th>
                                    <th class="pb-3">Property</th>
                                    <th class="pb-3">Rating</th>
                                    <th class="pb-3">Comment</th>
                                    <th class="pb-3">Date</th>
                                @elseif($reportType === 'payouts')
                                    <th class="pb-3">Booking</th>
                                    <th class="pb-3">Guest</th>
                                    <th class="pb-3">Check In</th>
                                    <th class="pb-3">Check Out</th>
                                    <th class="pb-3">Amount</th>
                                    <th class="pb-3">Status</th>
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
                                        <td class="py-3 text-sm text-gray-900">{{ $item->title ?? 'N/A' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->location ?? 'N/A' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->bookings_count ?? 0 }}</td>
                                        <td class="py-3 text-sm font-semibold text-green-600">${{ number_format($item->bookings_sum_total_amount ?? 0, 2) }}</td>
                                    @elseif($reportType === 'reviews')
                                        <td class="py-3 text-sm text-gray-900">{{ $item->reviewer->name ?? 'Anonymous' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->booking->property->title ?? 'N/A' }}</td>
                                        <td class="py-3">
                                            <div class="flex items-center gap-1">
                                                <div class="flex text-amber-400">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-3 h-3 {{ $i <= ($item->overall_rating ?? 0) ? 'text-amber-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                    @endfor
                                                </div>
                                                <span class="text-xs text-gray-500">{{ number_format($item->overall_rating ?? 0, 1) }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 text-sm text-gray-600 max-w-xs truncate">{{ $item->comment ?? 'No comment' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->created_at ? $item->created_at->format('M j, Y') : 'N/A' }}</td>
                                    @elseif($reportType === 'payouts')
                                        <td class="py-3 text-sm text-gray-600">#{{ $item->id }}</td>
                                        <td class="py-3 text-sm text-gray-900">{{ $item->user->name ?? 'N/A' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->check_in ? \Carbon\Carbon::parse($item->check_in)->format('M j, Y') : 'N/A' }}</td>
                                        <td class="py-3 text-sm text-gray-600">{{ $item->check_out ? \Carbon\Carbon::parse($item->check_out)->format('M j, Y') : 'N/A' }}</td>
                                        <td class="py-3 text-sm font-semibold text-green-600">${{ number_format($item->total_amount ?? 0, 2) }}</td>
                                        <td class="py-3"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $item->payout_status === 'paid' ? 'green' : ($item->payout_status === 'approved' ? 'blue' : 'yellow') }}-100 text-{{ $item->payout_status === 'paid' ? 'green' : ($item->payout_status === 'approved' ? 'blue' : 'yellow') }}-800 capitalize">{{ $item->payout_status ?? 'pending' }}</span></td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-500">No data available for the selected filters</td>
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
