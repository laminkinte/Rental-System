<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Bookings</h1>
            <p class="text-gray-600 mt-2">View and manage your reservations</p>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button 
                    wire:click="setTab('upcoming')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'upcoming' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                >
                    Upcoming
                </button>
                <button 
                    wire:click="setTab('past')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'past' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                >
                    Past
                </button>
                <button 
                    wire:click="setTab('all')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                >
                    All Bookings
                </button>
            </nav>
        </div>

        <!-- Bookings List -->
        @if($bookings->count() > 0)
            <div class="space-y-4">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="md:flex">
                            <!-- Property Image -->
                            <div class="md:w-48 h-48 md:h-auto bg-gray-200 relative">
                                @if($booking->property->images->count() > 0)
                                    <img src="{{ $booking->property->images->first()->url }}" alt="{{ $booking->property->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Booking Details -->
                            <div class="flex-1 p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $booking->property->title }}</h3>
                                        <p class="text-gray-600 text-sm mt-1">{{ $booking->property->location }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>

                                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Check-in</p>
                                        <p class="font-medium text-gray-900">{{ $booking->check_in->format('M j, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Check-out</p>
                                        <p class="font-medium text-gray-900">{{ $booking->check_out->format('M j, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Guests</p>
                                        <p class="font-medium text-gray-900">{{ $booking->guests }} guest(s)</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Total</p>
                                        <p class="font-medium text-gray-900">GMD {{ number_format($booking->total_amount, 2) }}</p>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end space-x-3">
                                    <a href="{{ route('bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        View Details
                                    </a>
                                    @if($booking->status === 'confirmed' && $booking->check_in->isFuture())
                                        <a href="{{ route('bookings.payment', $booking) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                            Pay Now
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No bookings found</h3>
                <p class="text-gray-600 mb-6">
                    @if($activeTab === 'upcoming')
                        You don't have any upcoming bookings. Start searching for your next stay!
                    @elseif($activeTab === 'past')
                        You haven't completed any stays yet.
                    @else
                        You haven't made any bookings yet.
                    @endif
                </p>
                <a href="{{ route('properties.search') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                    Find Properties
                </a>
            </div>
        @endif
    </div>
</div>
