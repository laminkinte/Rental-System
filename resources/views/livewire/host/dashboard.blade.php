<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Host Dashboard</h1>
            <p class="text-gray-600">Welcome back, {{ $user->name }}</p>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Active Listings</div>
                <div class="text-3xl font-bold text-gray-900">{{ $active_listings }}</div>
                @if($superhost)
                    <span class="inline-block mt-2 px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">Superhost ⭐</span>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Earnings This Month</div>
                <div class="text-3xl font-bold text-gray-900">GMD {{ number_format($earnings_this_month, 2) }}</div>
                <p class="text-xs text-gray-500 mt-1">{{ $recent_bookings->count() }} bookings</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Average Rating</div>
                <div class="text-3xl font-bold text-gray-900">{{ number_format($average_rating, 1) }}⭐</div>
                <p class="text-xs text-gray-500 mt-1">{{ $response_rate }}% response rate</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Total Earnings</div>
                <div class="text-3xl font-bold text-gray-900">GMD {{ number_format($total_earnings, 2) }}</div>
                <p class="text-xs text-gray-500 mt-1">All time</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('properties.create') }}" class="bg-blue-600 text-white rounded-lg shadow p-6 hover:bg-blue-700 transition text-center">
                <div class="text-lg font-semibold">+ Create New Listing</div>
                <p class="text-sm mt-2 text-blue-100">Add another property to your portfolio</p>
            </a>

            <a href="{{ route('messages.index') }}" class="bg-green-600 text-white rounded-lg shadow p-6 hover:bg-green-700 transition text-center">
                <div class="text-lg font-semibold">💬 Messages</div>
                <p class="text-sm mt-2 text-green-100">Communicate with guests</p>
            </a>

            <a href="{{ route('wallet.index') }}" class="bg-purple-600 text-white rounded-lg shadow p-6 hover:bg-purple-700 transition text-center">
                <div class="text-lg font-semibold">💳 Payouts</div>
                <p class="text-sm mt-2 text-purple-100">Manage payments & withdrawals</p>
            </a>

            <a href="{{ route('host.reports') }}" class="bg-pink-600 text-white rounded-lg shadow p-6 hover:bg-pink-700 transition text-center">
                <div class="text-lg font-semibold">📊 Reports</div>
                <p class="text-sm mt-2 text-pink-100">View performance analytics</p>
            </a>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Recent Bookings</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Guest</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Property</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Dates</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Amount</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($recent_bookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $booking->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $booking->property->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $booking->check_in->format('M j') }} - {{ $booking->check_out->format('M j') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">GMD {{ number_format($booking->total_amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-800">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
