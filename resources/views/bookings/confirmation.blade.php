<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Header -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Booking Confirmed!</h1>
                    <p class="text-lg text-gray-600">Your reservation has been successfully completed.</p>
                    @if(session('success'))
                        <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <!-- Booking Reference Card -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div>
                            <p class="text-blue-100 text-sm">Booking ID</p>
                            <p class="text-white text-2xl font-bold font-mono">#{{ $booking->id }}</p>
                        </div>
                        <div class="text-center sm:text-right">
                            <p class="text-blue-100 text-sm">Status</p>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold
                                @if($booking->status === 'confirmed') bg-green-200 text-green-800
                                @elseif($booking->status === 'pending') bg-yellow-200 text-yellow-800
                                @else bg-gray-200 text-gray-800 @endif">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Property Information -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Property Details</h2>
                    </div>
                    
                    <div class="flex items-start space-x-4 mb-4">
                        @php
                            $property = $booking->property ?? null;
                            $imagesRaw = $property->images ?? [];
                            $images = is_array($imagesRaw) ? $imagesRaw : json_decode($imagesRaw, true) ?? [];
                        @endphp
                        <div class="w-24 h-24 bg-gray-200 rounded-xl overflow-hidden flex-shrink-0">
                            @if(is_array($images) && count($images) > 0 && isset($images[0]))
                                <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $property->title ?? 'Property' }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-4xl">🏡</div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 text-lg">{{ $property->title ?? 'Property' }}</h3>
                            <p class="text-gray-500 text-sm">{{ $property->city ?? '' }}, {{ $property->country ?? 'Gambia' }}</p>
                            @if($property)
                                <p class="text-gray-600 text-sm mt-1">{{ $property->address ?? $property->location ?? '' }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-3 border-t border-gray-100 pt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Host:
                            </span>
                            <span class="font-medium">
                                @php
                                    $host = $property && $property->user ? $property->user : null;
                                @endphp
                                {{ $host ? ($host->name ?? $host->display_name ?? 'Host') : 'Host' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Stay Details -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Stay Details</h2>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">Check-in</span>
                                </div>
                                <span class="font-bold text-gray-900">{{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('M j, Y') : 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">Check-out</span>
                                </div>
                                <span class="font-bold text-gray-900">{{ $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('M j, Y') : 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-3 text-center">
                                <p class="text-sm text-gray-600">Guests</p>
                                <p class="text-xl font-bold text-gray-900">{{ $booking->guests ?? 1 }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3 text-center">
                                <p class="text-sm text-gray-600">Nights</p>
                                <p class="text-xl font-bold text-gray-900">{{ $booking->nights ?? $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) : 1 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mt-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">Payment Summary</h2>
                </div>

                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-green-800 font-medium">Payment Status</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-500 text-white">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $booking->payment_status === 'paid' ? 'Paid' : 'Completed' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-green-800 font-medium">Total Paid</span>
                        <span class="text-2xl font-bold text-green-700">${{ number_format($booking->total_amount ?? $booking->total_price ?? 0, 2) }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-500">Base Price</p>
                        <p class="font-bold text-gray-900">${{ number_format($booking->subtotal ?? 0, 2) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-500">Cleaning Fee</p>
                        <p class="font-bold text-gray-900">${{ number_format($booking->cleaning_fee ?? 0, 2) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-500">Service Fee</p>
                        <p class="font-bold text-gray-900">${{ number_format($booking->service_fee ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- What's Next -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mt-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">What's Next?</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Confirmation Email</h3>
                        <p class="text-sm text-gray-600">You'll receive a confirmation email with all booking details</p>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Message Host</h3>
                        <p class="text-sm text-gray-600">Contact your host directly through the messaging system</p>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Check-in Guide</h3>
                        <p class="text-sm text-gray-600">Check-in instructions will be provided before arrival</p>
                    </div>
                </div>

                <div class="mt-4 bg-green-50 border border-green-200 rounded-xl p-4">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-green-800">Free Cancellation Available</p>
                            <p class="text-sm text-green-600">Cancel before check-in for a full refund</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                @if($booking->property)
                    <a href="{{ route('properties.show', $booking->property) }}"
                       class="inline-flex items-center justify-center px-6 py-4 border border-transparent text-base font-bold rounded-xl text-white bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Property
                    </a>
                @endif
                <a href="{{ route('home') }}"
                   class="inline-flex items-center justify-center px-6 py-4 border-2 border-gray-300 text-base font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                    Browse More Properties
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
