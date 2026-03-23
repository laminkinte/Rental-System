<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Secure Payment</h1>
            <p class="text-gray-600 mt-2">Complete your booking securely</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <!-- Payment Methods Tabs -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Payment Method</h3>
                        <div class="grid grid-cols-3 gap-3">
                            <button type="button" onclick="selectPaymentMethod('card')" 
                                class="payment-method-btn active flex flex-col items-center p-4 border-2 border-gray-200 rounded-xl hover:border-pink-500 transition-all" 
                                data-method="card">
                                <svg class="w-8 h-8 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Card</span>
                            </button>
                            <button type="button" onclick="selectPaymentMethod('mobile')" 
                                class="payment-method-btn flex flex-col items-center p-4 border-2 border-gray-200 rounded-xl hover:border-pink-500 transition-all"
                                data-method="mobile">
                                <svg class="w-8 h-8 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Mobile Money</span>
                            </button>
                            <button type="button" onclick="selectPaymentMethod('bank')" 
                                class="payment-method-btn flex flex-col items-center p-4 border-2 border-gray-200 rounded-xl hover:border-pink-500 transition-all"
                                data-method="bank">
                                <svg class="w-8 h-8 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Bank Transfer</span>
                            </button>
                        </div>
                    </div>

                    <!-- Card Payment Form -->
                    <div id="card-form" class="payment-form">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                                <div class="relative">
                                    <input type="text" placeholder="1234 5678 9012 3456" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                        maxlength="19">
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 flex space-x-1">
                                        <img src="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/flags/4x3/visa.svg" alt="Visa" class="h-6 opacity-50">
                                        <img src="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/flags/4x3/mc.svg" alt="Mastercard" class="h-6 opacity-50">
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                                    <input type="text" placeholder="MM/YY" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                        maxlength="5">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">CVC</label>
                                    <input type="text" placeholder="123" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                        maxlength="4">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cardholder Name</label>
                                <input type="text" placeholder="John Doe" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Money Form -->
                    <div id="mobile-form" class="payment-form hidden">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Money Provider</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all">
                                    <option value="">Select Provider</option>
                                    <option value="orange">Orange Money</option>
                                    <option value="africell">Africell Money</option>
                                    <option value="gimac">GIMAC Pay</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" placeholder="+220 XXX XXXX" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all">
                            </div>
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                <p class="text-sm text-amber-800">
                                    <strong>Note:</strong> You will receive a confirmation prompt on your phone. Enter your PIN to complete the payment.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Transfer Form -->
                    <div id="bank-form" class="payment-form hidden">
                        <div class="space-y-4">
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                                <h4 class="font-semibold text-gray-900 mb-3">Bank Transfer Details</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Bank Name:</span>
                                        <span class="font-medium">Trust Bank Gambia</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Account Name:</span>
                                        <span class="font-medium">GambiaStays Ltd</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Account Number:</span>
                                        <span class="font-medium">1234567890</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Sort Code:</span>
                                        <span class="font-medium">GMB001</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Transaction Reference</label>
                                <input type="text" placeholder="Enter your payment reference" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all">
                            </div>
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                <p class="text-sm text-blue-800">
                                    <strong>Note:</strong> Please use booking ID as payment reference. Your booking will be confirmed once payment is verified (typically 1-2 business days).
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Error Message -->
                    @if($errorMessage)
                        <div class="mt-6 bg-red-50 border border-red-200 rounded-xl p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-red-700">{{ $errorMessage }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Pay Button -->
                    <div class="mt-8">
                        <button type="button" onclick="processPayment()" 
                            class="w-full bg-gradient-to-r from-pink-500 to-rose-500 text-white py-4 px-6 rounded-xl font-semibold text-lg hover:from-pink-600 hover:to-rose-600 focus:outline-none focus:ring-4 focus:ring-pink-300 transition-all transform hover:scale-[1.02]"
                            @if($paymentStatus === 'processing') disabled @endif>
                            @if($paymentStatus === 'processing')
                                <span class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processing Payment...
                                </span>
                            @else
                                <span class="flex items-center justify-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Pay ${{ number_format($booking->total_amount ?? $booking->total_price ?? 0, 2) }}
                                </span>
                            @endif
                        </button>
                    </div>

                    <!-- Security Badges -->
                    <div class="mt-6 flex items-center justify-center space-x-6 text-gray-400">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span class="text-xs">SSL Encrypted</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span class="text-xs">Secure Checkout</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <span class="text-xs">PCI Compliant</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking Summary</h3>
                    
                    <!-- Property Image & Name -->
                    <div class="flex items-center space-x-4 mb-6">
                        @php
                            $property = $booking->property ?? null;
                            $images = $property ? ($property->images ?? ($property->photos ?? [])) : [];
                        @endphp
                        <div class="w-20 h-20 bg-gray-200 rounded-xl overflow-hidden flex-shrink-0">
                            @if(count($images) > 0)
                                <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $property->title ?? 'Property' }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-3xl">🏡</div>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 line-clamp-2">{{ $property->title ?? 'Property' }}</h4>
                            <p class="text-sm text-gray-500">{{ $property->city ?? 'Gambia' }}, {{ $property->country ?? 'Gambia' }}</p>
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="border-t border-gray-100 pt-4 mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Check-in</span>
                            <span class="font-medium">{{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('M j, Y') : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Check-out</span>
                            <span class="font-medium">{{ $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('M j, Y') : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Guests</span>
                            <span class="font-medium">{{ $booking->guests ?? 1 }}</span>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="border-t border-gray-100 pt-4 space-y-3">
                        @php
                            $basePrice = $property->base_price ?? 0;
                            $nights = $booking->nights ?? $booking->total_nights ?? 1;
                            $subtotal = $nights * $basePrice;
                            $cleaningFee = $booking->cleaning_fee ?? ($property->cleaning_fee ?? 0);
                            $serviceFee = $booking->service_fee ?? round($subtotal * 0.12);
                            $total = $booking->total_amount ?? $booking->total_price ?? ($subtotal + $cleaningFee + $serviceFee);
                        @endphp
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">${{ number_format($basePrice, 2) }} x {{ $nights }} night{{ $nights > 1 ? 's' : '' }}</span>
                            <span class="text-gray-900">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Cleaning fee</span>
                            <span class="text-gray-900">${{ number_format($cleaningFee, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Service fee</span>
                            <span class="text-gray-900">${{ number_format($serviceFee, 2) }}</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Total</span>
                                <span class="text-xl font-bold text-gray-900">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Free Cancellation Notice -->
                    <div class="mt-6 bg-green-50 border border-green-200 rounded-xl p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-green-800">Free Cancellation</p>
                                <p class="text-xs text-green-600 mt-1">Cancel before check-in for a full refund</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedMethod = 'card';

    function selectPaymentMethod(method) {
        selectedMethod = method;
        
        // Update button states
        document.querySelectorAll('.payment-method-btn').forEach(btn => {
            btn.classList.remove('active', 'border-pink-500', 'bg-pink-50');
            btn.classList.add('border-gray-200');
        });
        const activeBtn = document.querySelector(`[data-method="${method}"]`);
        activeBtn.classList.add('active', 'border-pink-500', 'bg-pink-50');
        activeBtn.classList.remove('border-gray-200');
        
        // Show/hide forms
        document.querySelectorAll('.payment-form').forEach(form => {
            form.classList.add('hidden');
        });
        document.getElementById(`${method}-form`).classList.remove('hidden');
    }

    function processPayment() {
        // Simulate payment processing
        const button = event.target.closest('button');
        button.disabled = true;
        button.innerHTML = `
            <span class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing Payment...
            </span>
        `;

        // For demo, simulate success after 2 seconds
        setTimeout(() => {
            // Dispatch Livewire event
            if (typeof Livewire !== 'undefined') {
                Livewire.dispatch('paymentCompleted', { paymentIntentId: 'demo_' + Date.now() });
            } else {
                // Fallback redirect for demo
                window.location.href = '{{ route("booking.confirmation", $booking) }}';
            }
        }, 2000);
    }

    // Format card number input
    document.querySelector('input[placeholder="1234 5678 9012 3456"]')?.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(.{4})/g, '$1 ').trim();
        e.target.value = value;
    });

    // Format expiry date input
    document.querySelector('input[placeholder="MM/YY"]')?.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
    });
</script>

<style>
    .payment-method-btn.active {
        border-color: #ec4899;
        background-color: #fdf2f8;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
