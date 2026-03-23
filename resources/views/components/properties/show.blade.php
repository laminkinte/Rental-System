<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('properties.search') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to search
                </a>
                <div class="flex items-center space-x-2">
                    <button class="p-2 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    <button class="p-2 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Property Images -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    @if($property->photos && count($property->photos) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 p-4">
                            @foreach(array_slice($property->photos, 0, 4) as $index => $photo)
                                <div class="aspect-w-16 aspect-h-12">
                                    <img src="{{ $photo }}" alt="Property image {{ $index + 1 }}"
                                         class="w-full h-full object-cover rounded-lg">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="h-96 bg-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Property Details -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $property->title }}</h1>
                            <p class="text-gray-600">{{ $property->city }}, Gambia</p>
                        </div>
                        <div class="flex items-center">
                            @if($property->verified_listing)
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    Verified
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->guest_capacity }}</div>
                            <div class="text-sm text-gray-600">Guests</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->bedrooms }}</div>
                            <div class="text-sm text-gray-600">Bedrooms</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->bathrooms }}</div>
                            <div class="text-sm text-gray-600">Bathrooms</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->size_sqm }}m²</div>
                            <div class="text-sm text-gray-600">Size</div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h2 class="text-xl font-semibold mb-4">About this place</h2>
                        <p class="text-gray-700 leading-relaxed">{{ $property->description }}</p>
                    </div>
                </div>

                <!-- Amenities -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Amenities</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @if($property->running_water) <div class="flex items-center"><span class="text-green-500 mr-2">✓</span>Running Water</div> @endif
                        @if($property->electricity) <div class="flex items-center"><span class="text-green-500 mr-2">✓</span>Electricity</div> @endif
                        @if($property->wifi) <div class="flex items-center"><span class="text-green-500 mr-2">✓</span>WiFi</div> @endif
                        @if($property->air_conditioning) <div class="flex items-center"><span class="text-green-500 mr-2">✓</span>Air Conditioning</div> @endif
                        @if($property->kitchen_access) <div class="flex items-center"><span class="text-green-500 mr-2">✓</span>Kitchen Access</div> @endif
                        @if($property->parking) <div class="flex items-center"><span class="text-green-500 mr-2">✓</span>Parking</div> @endif
                        @if($property->security_guard) <div class="flex items-center"><span class="text-green-500 mr-2">✓</span>Security Guard</div> @endif
                        @if($property->terrace) <div class="flex items-center"><span class="text-green-500 mr-2">✓</span>Terrace</div> @endif
                        @if($property->garden) <div class="flex items-center"><span class="text-green-500 mr-2">✓</span>Garden</div> @endif
                        @if($property->welcome_drink) <div class="flex items-center"><span class="text-green-500 mr-2">✓</span>Welcome Drink</div> @endif
                        @if($property->local_breakfast) <div class="flex items-center"><span class="text-green-500 mr-2">✓</span>Local Breakfast</div> @endif
                    </div>
                </div>

                <!-- Host Information -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Hosted by {{ $property->host->name }}</h2>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center mr-4">
                            <span class="text-gray-600 font-medium">{{ substr($property->host->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-gray-700">{{ $property->host->profile->bio ?? 'Local host in Gambia' }}</p>
                            <p class="text-sm text-gray-500">Host since {{ $property->host->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- House Rules -->
                @if($property->rules)
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">House Rules</h2>
                    <div class="prose prose-sm max-w-none">
                        {!! nl2br(e($property->rules)) !!}
                    </div>
                </div>
                @endif
            </div>

            <!-- Booking Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-2xl font-bold text-gray-900">GMD {{ number_format($property->base_price) }}</span>
                            <span class="text-gray-600"> / night</span>
                        </div>
                        @if($property->quality_score)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600 ml-1">{{ number_format($property->quality_score, 1) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Booking Form -->
                    <form wire:submit="book" class="space-y-4">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Check-in</label>
                                <input type="date" wire:model="check_in"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('check_in') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Check-out</label>
                                <input type="date" wire:model="check_out"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('check_out') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Guests</label>
                            <select wire:model="guests" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @for($i = 1; $i <= $property->guest_capacity; $i++)
                                    <option value="{{ $i }}">{{ $i }} guest{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                            @error('guests') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        @if($total_nights > 0)
                            <div class="border-t pt-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span>GMD {{ number_format($property->base_price) }} × {{ $total_nights }} nights</span>
                                    <span>GMD {{ number_format($subtotal) }}</span>
                                </div>
                                @if($cleaning_fee > 0)
                                    <div class="flex justify-between text-sm">
                                        <span>Cleaning fee</span>
                                        <span>GMD {{ number_format($cleaning_fee) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between text-sm">
                                    <span>Service fee</span>
                                    <span>GMD {{ number_format($service_fee) }}</span>
                                </div>
                                <div class="border-t pt-2 flex justify-between font-semibold">
                                    <span>Total</span>
                                    <span>GMD {{ number_format($total) }}</span>
                                </div>
                            </div>
                        @endif

                        @error('booking') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror

                        @auth
                            <button type="submit"
                                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 transition-colors font-medium">
                                @if($property->instant_book)
                                    Book Instantly
                                @else
                                    Request to Book
                                @endif
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                               class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 transition-colors font-medium text-center block">
                                Log in to Book
                            </a>
                        @endauth
                    </form>

                    @if($property->instant_book)
                        <p class="text-xs text-gray-500 mt-2 text-center">This property offers instant booking</p>
                    @else
                        <p class="text-xs text-gray-500 mt-2 text-center">You'll need to wait for host approval</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>