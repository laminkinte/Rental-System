<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Property Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ $property->title }}</h1>
            <div class="flex items-center gap-4 mt-2 text-gray-600">
                <span>{{ $property->city ?? 'The Gambia' }}, {{ $property->country ?? 'Gambia' }}</span>
                <span>•</span>
                <span>{{ $property->guest_capacity ?? 1 }} guests</span>
                <span>•</span>
                <span>{{ $property->bedrooms ?? 1 }} bedrooms</span>
                <span>•</span>
                <span>{{ $property->beds ?? 1 }} beds</span>
            </div>
        </div>

        <!-- Image Gallery -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg overflow-hidden">
                @php
                    $images = is_string($property->images) ? json_decode($property->images, true) : ($property->images ?? ($property->photos ?? []));
                @endphp
                @if(is_array($images) && count($images) > 0)
                    <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $property->title }}" class="w-full h-64 object-cover">
                @else
                    <div class="w-full h-64 bg-gray-300 flex items-center justify-center">
                        <span class="text-gray-500 text-4xl">🏡</span>
                    </div>
                @endif
            </div>
            <div class="grid grid-cols-2 gap-4">
                @php
                    $images = is_string($property->images) ? json_decode($property->images, true) : ($property->images ?? ($property->photos ?? []));
                @endphp
                @if(is_array($images) && count($images) > 1)
                    @foreach(array_slice($images, 1, 4) as $image)
                        <div class="bg-gray-200 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $property->title }}" class="w-full h-32 object-cover">
                        </div>
                    @endforeach
                @else
                    @for($i = 1; $i < 5; $i++)
                        <div class="bg-gray-300 rounded-lg"></div>
                    @endfor
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Description -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">About this place</h2>
                    <p class="text-gray-600 whitespace-pre-line">{{ $property->description ?? 'No description available.' }}</p>
                </div>

                <!-- Amenities -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">What this place offers</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @php
                            $amenities = is_string($property->amenities) ? json_decode($property->amenities, true) : ($property->amenities ?? []);
                        @endphp
                        @if(is_array($amenities) && count($amenities) > 0)
                            @foreach($amenities as $amenity)
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>{{ ucfirst($amenity) }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 col-span-2">No amenities listed</p>
                        @endif
                    </div>
                </div>

                <!-- Map with Leaflet -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Location</h2>
                    @if($property->latitude && $property->longitude)
                        <div id="propertyMap" class="w-full h-72 rounded-lg"
                             data-lat="{{ $property->latitude }}"
                             data-lng="{{ $property->longitude }}"
                             data-title="{{ addslashes($property->title ?? 'Property') }}"
                             data-address="{{ addslashes($property->address ?? '') }}">
                        </div>
                        
                        <!-- Leaflet CSS and JS -->
                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                setTimeout(function() {
                                    if (typeof L === 'undefined') {
                                        console.log('Leaflet not loaded');
                                        return;
                                    }
                                    
                                    var mapContainer = document.getElementById('propertyMap');
                                    if (!mapContainer) return;
                                    
                                    // Check if map already initialized
                                    if (mapContainer._leaflet_id) return;
                                    
                                    var lat = parseFloat(mapContainer.dataset.lat) || 13.4545;
                                    var lng = parseFloat(mapContainer.dataset.lng) || -15.5978;
                                    var title = mapContainer.dataset.title || 'Property';
                                    var address = mapContainer.dataset.address || '';
                                    
                                    // Create map
                                    var map = L.map('propertyMap').setView([lat, lng], 15);
                                    
                                    // Add tile layer
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                    }).addTo(map);
                                    
                                    // Custom marker icon
                                    var icon = L.divIcon({
                                        className: 'custom-marker',
                                        html: '<div style="background:#FF385C;width:36px;height:36px;border-radius:50%;border:4px solid white;box-shadow:0 3px 8px rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;color:white;font-weight:bold;font-size:14px;">🏠</div>',
                                        iconSize: [36, 36],
                                        iconAnchor: [18, 36],
                                        popupAnchor: [0, -36]
                                    });
                                    
                                    // Add marker
                                    L.marker([lat, lng], { icon: icon }).addTo(map)
                                        .bindPopup('<div style="min-width:150px"><strong>' + title + '</strong><br><small>' + address + '</small></div>')
                                        .openPopup();
                                }, 300);
                            });
                        </script>
                        
                        <style>
                            #propertyMap { min-height: 288px; }
                            #propertyMap .leaflet-container { height: 100%; width: 100%; border-radius: 0.5rem; }
                            .custom-marker { background: transparent !important; border: none !important; }
                        </style>
                    @else
                        <div class="bg-gray-200 rounded-lg h-64 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-gray-600">{{ $property->city ?? 'Location' }}, {{ $property->country ?? 'Gambia' }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Host Info -->
                @if($property->host)
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Hosted by</h2>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center">
                            <span class="text-2xl">{{ substr($property->host->name ?? 'H', 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold">{{ $property->host->name ?? 'Host' }}</p>
                            <p class="text-gray-500 text-sm">Property Owner</p>
                        </div>
                    </div>
                    @auth
                        @if(auth()->id() !== $property->host_id)
                        <div class="mt-4 pt-4 border-t">
                            <a href="{{ route('messages.show', $property->host) }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Contact Host
                            </a>
                        </div>
                        @endif
                    @else
                        <div class="mt-4 pt-4 border-t">
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Login to Contact Host
                            </a>
                        </div>
                    @endauth
                </div>
                @endif

                <!-- Reviews -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Reviews</h2>
                    <p class="text-gray-600">Reviews will appear here</p>
                </div>
            </div>

            <!-- Booking Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                    <div class="flex items-baseline gap-2 mb-4">
                        <span class="text-3xl font-bold text-gray-900">${{ number_format($property->base_price ?? 50) }}</span>
                        <span class="text-gray-600">/ night</span>
                    </div>

                    <form wire:submit.prevent="book">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Check-in</label>
                                <input type="date" wire:model="check_in" min="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Check-out</label>
                                <input type="date" wire:model="check_out" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Guests</label>
                            <select wire:model="guests" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                @for($i = 1; $i <= ($property->guest_capacity ?? 1); $i++)
                                    <option value="{{ $i }}">{{ $i }} guest{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>

                        @error('booking')
                            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-sm">
                                {{ $message }}
                            </div>
                        @enderror

                        @if($total > 0)
                            <div class="border-t pt-4 mb-4 space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">${{ number_format($property->base_price ?? 50) }} x {{ $total_nights }} nights</span>
                                    <span>${{ number_format($subtotal) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Cleaning fee</span>
                                    <span>${{ number_format($cleaning_fee) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Service fee</span>
                                    <span>${{ number_format($service_fee) }}</span>
                                </div>
                                <div class="flex justify-between font-bold pt-2 border-t">
                                    <span>Total</span>
                                    <span>${{ number_format($total) }}</span>
                                </div>
                            </div>
                        @endif

                        <button type="submit" class="w-full bg-pink-500 text-white py-3 rounded-lg font-semibold hover:bg-pink-600 transition-colors">
                            Reserve
                        </button>
                    </form>

                    <p class="text-center text-gray-500 text-sm mt-4">You won't be charged yet</p>
                </div>
            </div>
        </div>
    </div>
</div>
