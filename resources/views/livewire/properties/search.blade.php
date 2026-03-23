<div class="min-h-screen bg-gray-50">
    <!-- Search Header -->
    <div class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Location Search -->
                <div class="flex-1">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Location</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <input type="text" wire:model.live.debounce.300ms="location" 
                            placeholder="Where are you going?" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    </div>
                </div>
                
                <!-- Check-in Date -->
                <div class="w-full lg:w-48">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Check-in</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <input type="date" wire:model.live.debounce.300ms="check_in" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    </div>
                </div>
                
                <!-- Check-out Date -->
                <div class="w-full lg:w-48">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Check-out</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <input type="date" wire:model.live.debounce.300ms="check_out" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    </div>
                </div>
                
                <!-- Guests -->
                <div class="w-full lg:w-40">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Guests</label>
                    <select wire:model.live="guest_capacity" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                        <option value="">Any</option>
                        @for($i = 1; $i <= 20; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'guest' : 'guests' }}</option>
                        @endfor
                    </select>
                </div>
                
                <!-- Search Button -->
                <div class="flex items-end">
                    <button wire:click="$refresh" class="w-full lg:w-auto px-8 py-3 bg-[#FF385C] text-white font-semibold rounded-xl hover:bg-[#E2324A] transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Search
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex flex-col lg:flex-row gap-6">
            
            <!-- Filters Sidebar -->
            <div class="lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-semibold text-gray-900">Filters</h3>
                        <button wire:click="clearFilters" class="text-sm text-[#FF385C] hover:underline">Clear all</button>
                    </div>
                    
                    <!-- Price Range -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Price range</h4>
                        <div class="flex gap-2">
                            <div class="flex-1">
                                <input type="number" wire:model.live.debounce.300ms="min_price" placeholder="Min" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                            </div>
                            <span class="text-gray-400 self-center">-</span>
                            <div class="flex-1">
                                <input type="number" wire:model.live.debounce.300ms="max_price" placeholder="Max" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Property Type -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Property type</h4>
                        <select wire:model.live="gambia_category" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                            <option value="">All types</option>
                            @foreach($gambiaCategories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Rooms & Beds -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Rooms & Beds</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Bedrooms</span>
                                <select wire:model.live="bedrooms" class="px-3 py-1 border border-gray-200 rounded-lg text-sm">
                                    <option value="">Any</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}+</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Bathrooms</span>
                                <select wire:model.live="bathrooms" class="px-3 py-1 border border-gray-200 rounded-lg text-sm">
                                    <option value="">Any</option>
                                    @for($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}">{{ $i }}+</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Amenities -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Amenities</h4>
                        <div class="space-y-2">
                            @foreach($amenityOptions as $key => $label)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model.live="amenities" value="{{ $key }}" 
                                        class="w-4 h-4 text-[#FF385C] border-gray-300 rounded focus:ring-[#FF385C]">
                                    <span class="text-sm text-gray-600">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Quick Filters -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-gray-50">
                            <input type="checkbox" wire:model.live="instant_book" class="w-4 h-4 text-[#FF385C] border-gray-300 rounded focus:ring-[#FF385C]">
                            <span class="text-sm text-gray-700">Instant Book</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-gray-50">
                            <input type="checkbox" wire:model.live="verified_only" class="w-4 h-4 text-[#FF385C] border-gray-300 rounded focus:ring-[#FF385C]">
                            <span class="text-sm text-gray-700">Verified Listings</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="flex-1">
                <!-- Results Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">
                            @if($properties->total() > 0)
                                {{ $properties->total() }} properties found
                            @else
                                No properties found
                            @endif
                        </h2>
                        @if($location)
                            <p class="text-sm text-gray-500">in {{ $location }}</p>
                        @endif
                    </div>
                    
                    <!-- Sort Dropdown -->
                    <select wire:model.live="sort_by" class="px-4 py-2 border border-gray-200 rounded-lg text-sm">
                        <option value="created_at">Most Recent</option>
                        <option value="base_price">Price: Low to High</option>
                        <option value="base_price_desc">Price: High to Low</option>
                        <option value="quality_score">Top Rated</option>
                    </select>
                </div>
                
                <!-- View Toggle -->
                <div class="flex gap-2 mb-6">
                    <button wire:click="$set('viewMode', 'grid')" 
                        class="px-4 py-2 rounded-lg border {{ $viewMode === 'grid' ? 'bg-gray-100 border-gray-300' : 'border-gray-200' }} text-sm font-medium">
                        Grid
                    </button>
                    <button wire:click="$set('viewMode', 'list')" 
                        class="px-4 py-2 rounded-lg border {{ $viewMode === 'list' ? 'bg-gray-100 border-gray-300' : 'border-gray-200' }} text-sm font-medium">
                        List
                    </button>
                    <button wire:click="$set('viewMode', 'map')" 
                        class="px-4 py-2 rounded-lg border {{ $viewMode === 'map' ? 'bg-gray-100 border-gray-300' : 'border-gray-200' }} text-sm font-medium">
                        Map
                    </button>
                </div>
                
                <!-- Grid View -->
                @if($viewMode === 'grid')
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($properties as $property)
                    <a href="{{ route('properties.show', $property) }}" class="group">
                        <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300">
                            <!-- Image -->
                            <div class="relative aspect-[4/3] overflow-hidden bg-gray-200">
                                @php $propImages = $property->images ?? ($property->photos ?? []); @endphp
                                @if(count($propImages) > 0)
                                    <img src="{{ asset('storage/' . $propImages[0]) }}" 
                                         alt="{{ $property->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Wishlist -->
                                <button class="absolute top-3 right-3 p-2 rounded-full bg-white/80 hover:bg-white transition-colors">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                                
                                <!-- Category Badge -->
                                @if($property->gambia_category)
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-black/60 text-white text-xs font-medium px-2 py-1 rounded">
                                            {{ $gambiaCategories[$property->gambia_category] ?? ucfirst(str_replace('_', ' ', $property->gambia_category)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="p-4">
                                <div class="flex items-start justify-between mb-1">
                                    <h3 class="font-semibold text-gray-900 truncate flex-1">{{ $property->title }}</h3>
                                    @if($property->quality_score >= 4.5)
                                        <div class="flex items-center gap-1 ml-2">
                                            <svg class="w-4 h-4 text-[#FF385C]" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="text-sm font-medium">{{ number_format($property->quality_score, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <p class="text-sm text-gray-500 mb-2 truncate">{{ $property->city }}, {{ $property->country }}</p>
                                
                                <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                                    <span>{{ $property->bedrooms ?? 1 }} beds</span>
                                    <span>·</span>
                                    <span>{{ $property->bathrooms ?? 1 }} baths</span>
                                    <span>·</span>
                                    <span>{{ $property->guest_capacity ?? 2 }} guests</span>
                                </div>
                                
                                <div class="flex items-baseline gap-1">
                                    <span class="text-lg font-bold text-gray-900">${{ number_format($property->base_price ?? 50) }}</span>
                                    <span class="text-sm text-gray-600">/ night</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-6xl mb-4">🏠</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No properties found</h3>
                        <p class="text-gray-600">Try adjusting your search filters</p>
                    </div>
                    @endforelse
                </div>
                @endif
                
                <!-- List View -->
                @if($viewMode === 'list')
                <div class="space-y-4">
                    @forelse($properties as $property)
                    <a href="{{ route('properties.show', $property) }}" class="group block bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all p-4">
                        <div class="flex gap-6">
                            <div class="w-64 h-48 rounded-xl overflow-hidden bg-gray-200 flex-shrink-0">
                                @if($property->photos && count($property->photos) > 0)
                                    <img src="{{ asset('storage/' . $property->photos[0]) }}" 
                                         alt="{{ $property->title }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 py-2">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="font-semibold text-lg text-gray-900 mb-1">{{ $property->title }}</h3>
                                        <p class="text-sm text-gray-500 mb-2">{{ $property->city }}, {{ $property->country }}</p>
                                    </div>
                                    @if($property->quality_score >= 4.5)
                                    <div class="flex items-center gap-1">
                                        <svg class="w-5 h-5 text-[#FF385C]" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="font-medium">{{ number_format($property->quality_score, 1) }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                    <span>{{ $property->bedrooms ?? 1 }} bedrooms</span>
                                    <span>{{ $property->bathrooms ?? 1 }} bathrooms</span>
                                    <span>{{ $property->guest_capacity ?? 2 }} guests</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    @if($property->instant_book)
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Instant Book</span>
                                    @endif
                                    @if($property->verified_listing)
                                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">Verified</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900">${{ number_format($property->base_price ?? 50) }}</div>
                                <div class="text-sm text-gray-500">per night</div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">🏠</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No properties found</h3>
                        <p class="text-gray-600">Try adjusting your search filters</p>
                    </div>
                    @endforelse
                </div>
                @endif
                
                <!-- Map View -->
                @if($viewMode === 'map')
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                    <!-- Properties List -->
                    <div class="space-y-4 max-h-[calc(100vh-200px)] overflow-y-auto pr-2">
                        @forelse($properties as $property)
                        <a href="{{ route('properties.show', $property) }}" class="group block bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all p-3">
                            <div class="flex gap-4">
                                <div class="w-32 h-24 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0">
                                    @if($property->photos && count($property->photos) > 0)
                                        <img src="{{ asset('storage/' . $property->photos[0]) }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 truncate">{{ $property->title }}</h3>
                                    <p class="text-sm text-gray-500">{{ $property->city }}</p>
                                    <div class="mt-2 flex items-center justify-between">
                                        <span class="font-bold text-lg">${{ number_format($property->base_price ?? 50) }}</span>
                                        <span class="text-sm text-gray-500">/night</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">No properties found</p>
                        </div>
                        @endforelse
                    </div>
                    
                    <!-- Map Container - Embedded Leaflet Map -->
                    <div class="h-[calc(100vh-200px)] rounded-2xl overflow-hidden sticky top-24 border border-gray-200">
                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                        <div id="property-map" class="w-full h-full"></div>
                        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Initialize map centered on The Gambia
                                const map = L.map('property-map').setView([13.4544, -15.3101], 8);
                                
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; OpenStreetMap contributors'
                                }).addTo(map);
                                
                                // Sample property data
                                const properties = {!! json_encode($properties->map(function($p) {
                                    return [
                                        'id' => $p->id,
                                        'title' => $p->title,
                                        'lat' => $p->latitude ?? (13.4 + (mt_rand(-100, 100) / 1000)),
                                        'lng' => $p->longitude ?? (-15.3 + (mt_rand(-100, 100) / 1000)),
                                        'price' => $p->base_price ?? 50,
                                        'url' => route('properties.show', $p->id)
                                    ];
                                })) !!};
                                
                                properties.forEach(function(prop) {
                                    const marker = L.marker([prop.lat, prop.lng]).addTo(map);
                                    marker.bindPopup('<div class="p-2"><h4 class="font-semibold">' + prop.title + '</h4><p class="text-pink-500 font-bold">$' + prop.price + '/night</p><a href="' + prop.url + '" class="text-sm text-blue-600 hover:underline">View Details</a></div>');
                                });
                            });
                        </script>
                    </div>
                </div>
                @endif
                
                <!-- Pagination -->
                @if($properties->hasPages())
                <div class="mt-8">
                    {{ $properties->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
