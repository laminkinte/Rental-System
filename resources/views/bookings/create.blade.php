<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Book Your Stay</h1>
                <p class="text-gray-600 mt-2">Complete your reservation at {{ $property->title }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Main Form -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6">
                            <!-- Property Summary -->
                            <div class="mb-6 pb-6 border-b border-gray-200">
                                <div class="flex items-center space-x-4">
                                    @if($property->images && $property->images->count() > 0)
                                        <img src="{{ $property->images->first()->url }}" alt="{{ $property->title }}" class="w-24 h-24 object-cover rounded-lg">
                                    @else
                                        <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $property->title }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $property->location ?? 'The Gambia' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Form -->
                            <form action="{{ route('bookings.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="property_id" value="{{ $property->id }}">
                                
                                <!-- Dates -->
                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Check-in</label>
                                        <input type="date" name="check_in" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Check-out</label>
                                        <input type="date" name="check_out" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    </div>
                                </div>

                                <!-- Guests -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of Guests</label>
                                    <select name="guests" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                        @for($i = 1; $i <= ($property->max_guests ?? 10); $i++)
                                            <option value="{{ $i }}">{{ $i }} guest{{ $i > 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Special Requests -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Special Requests (optional)</label>
                                    <textarea name="special_requests" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Any special requests or requirements..."></textarea>
                                </div>

                                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                                    Continue to Payment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Price Summary -->
                <div>
                    <div class="bg-white rounded-lg shadow sticky top-8">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Price Details</h3>
                            
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">GMD {{ number_format($property->price_per_night ?? 0, 2) }} x <span id="nights">1</span> night</span>
                                    <span class="text-gray-900">GMD <span id="subtotal">{{ number_format($property->price_per_night ?? 0, 2) }}</span></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Cleaning fee</span>
                                    <span class="text-gray-900">GMD {{ number_format($property->cleaning_fee ?? 0, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Service fee</span>
                                    <span class="text-gray-900">GMD {{ number_format(($property->price_per_night ?? 0) * 0.1, 2) }}</span>
                                </div>
                                <div class="border-t pt-3 flex justify-between font-semibold">
                                    <span class="text-gray-900">Total</span>
                                    <span class="text-gray-900">GMD {{ number_format(($property->price_per_night ?? 0) + ($property->cleaning_fee ?? 0) + (($property->price_per_night ?? 0) * 0.1), 2) }}</span>
                                </div>
                            </div>

                            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    <span class="font-medium">Free cancellation</span><br>
                                    Cancel before check-in for a full refund.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const pricePerNight = {{ $property->price_per_night ?? 0 }};
        const cleaningFee = {{ $property->cleaning_fee ?? 0 }};
        const serviceFee = pricePerNight * 0.1;

        const checkInInput = document.querySelector('input[name="check_in"]');
        const checkOutInput = document.querySelector('input[name="check_out"]');

        function calculateTotal() {
            if (checkInInput.value && checkOutInput.value) {
                const checkIn = new Date(checkInInput.value);
                const checkOut = new Date(checkOutInput.value);
                const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));

                if (nights > 0) {
                    const subtotal = pricePerNight * nights;
                    
                    document.getElementById('nights').textContent = nights;
                    document.getElementById('subtotal').textContent = subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                }
            }
        }

        checkInInput.addEventListener('change', calculateTotal);
        checkOutInput.addEventListener('change', calculateTotal);

        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        checkInInput.setAttribute('min', today);
        checkOutInput.setAttribute('min', today);
    </script>
    @endpush
</x-app-layout>
