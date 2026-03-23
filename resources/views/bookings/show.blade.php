<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Booking Details</h1>
                        <p class="text-sm text-gray-600">Reference: <span class="font-mono">{{ $booking->id }}</span></p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Property</h2>
                        <a href="{{ route('properties.show', $booking->property) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            {{ $booking->property->title }}
                        </a>
                        <p class="text-sm text-gray-600 mt-2">{{ $booking->property->city }}, {{ $booking->property->country }}</p>
                        <p class="text-sm text-gray-600 mt-2">Host: {{ $booking->property->host->name }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Stay Details</h2>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Check-in</span>
                                <span>{{ $booking->check_in->format('M j, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Check-out</span>
                                <span>{{ $booking->check_out->format('M j, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Guests</span>
                                <span>{{ $booking->guests }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Total Nights</span>
                                <span>{{ $booking->total_nights }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Price Breakdown</h2>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>GMD {{ number_format($booking->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Cleaning Fee</span>
                            <span>GMD {{ number_format($booking->cleaning_fee, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Service Fee</span>
                            <span>GMD {{ number_format($booking->service_fee, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-semibold border-t pt-2">
                            <span>Total</span>
                            <span>GMD {{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if(!$booking->payment)
                    <div class="text-center">
                        <a href="{{ route('bookings.payment', $booking) }}" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Proceed to Payment
                        </a>
                    </div>
                @else
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Payment Status</h2>
                        <div class="flex justify-between text-sm text-gray-700">
                            <span>Status</span>
                            <span class="font-medium">{{ ucfirst($booking->payment->status) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-700">
                            <span>Amount</span>
                            <span class="font-medium">GMD {{ number_format($booking->payment->amount, 2) }}</span>
                        </div>
                        @if($booking->payment->processed_at)
                            <div class="flex justify-between text-sm text-gray-700">
                                <span>Processed At</span>
                                <span class="font-medium">{{ $booking->payment->processed_at->format('M j, Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('properties.show', $booking->property) }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        View Property
                    </a>
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Browse More Stays
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
