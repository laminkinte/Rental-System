<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900">Find Your Perfect Stay in Gambia</h1>
                <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">← Back to Home</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Filters</h2>
                        <button wire:click="clearFilters" class="text-sm text-blue-600 hover:text-blue-800">
                            Clear all
                        </button>
                    </div>

                    <!-- Search Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input type="text" wire:model.live.debounce.300ms="search"
                               placeholder="Property name, location..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Location -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input type="text" wire:model.live.debounce.300ms="location"
                               placeholder="City, area..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Gambia Category -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                        <select wire:model.live="gambia_category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Types</option>
                            @foreach($gambiaCategories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price Range (GMD)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" wire:model.live.debounce.300ms="min_price"
                                   placeholder="Min" min="0"
                                   class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="number" wire:model.live.debounce.300ms="max_price"
                                   placeholder="Max" min="0"
                                   class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Guest Capacity -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Guests</label>
                        <select wire:model.live="guest_capacity" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Any</option>
                            <option value="1">1 guest</option>
                            <option value="2">2 guests</option>
                            <option value="3">3 guests</option>
                            <option value="4">4 guests</option>
                            <option value="5">5+ guests</option>
                        </select>
                    </div>

                    <!-- Bedrooms -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                        <select wire:model.live="bedrooms" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Any</option>
                            <option value="1">1 bedroom</option>
                            <option value="2">2 bedrooms</option>
                            <option value="3">3 bedrooms</option>
                            <option value="4">4+ bedrooms</option>
                        </select>
                    </div>

                    <!-- Amenities -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Amenities</label>
                        <div class="space-y-2">
                            @foreach($amenityOptions as $key => $label)
                                <label class="flex items-center">
                                    <input type="checkbox"
                                           wire:click="toggleAmenity('{{ $key }}')"
                                           {{ in_array($key, $this->amenities) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Additional Options -->
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="instant_book"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Instant Book</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="verified_only"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Verified Properties Only</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div class="lg:col-span-3">
                <!-- Sort Options -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            {{ $properties->total() }} properties found
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">Sort by:</span>
                            <select wire:model.live="sort_by" class="text-sm border border-gray-300 rounded px-2 py-1">
                                <option value="created_at">Newest</option>
                                <option value="base_price">Price: Low to High</option>
                                <option value="base_price">Price: High to Low</option>
                                <option value="quality_score">Quality Score</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Property Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($properties as $property)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <!-- Property Image -->
                            <div class="relative h-48 bg-gray-200">
                                @if($property->photos && count($property->photos) > 0)
                                    <img src="{{ $property->photos[0] }}" alt="{{ $property->title }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                @endif
                                @if($property->verified_listing)
                                    <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                        Verified
                                    </div>
                                @endif
                                @if($property->instant_book)
                                    <div class="absolute top-2 left-2 bg-blue-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                        Instant Book
                                    </div>
                                @endif
                            </div>

                            <!-- Property Details -->
                            <div class="p-4">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate">
                                        {{ $property->title }}
                                    </h3>
                                    <div class="flex items-center ml-2">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-sm text-gray-600 ml-1">
                                            {{ number_format($property->quality_score ?? 0, 1) }}
                                        </span>
                                    </div>
                                </div>

                                <p class="text-sm text-gray-600 mb-2">
                                    {{ $property->city }}, Gambia
                                </p>

                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <span>{{ $property->guest_capacity }} guests</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $property->bedrooms }} bedrooms</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $property->bathrooms }} bathrooms</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-lg font-bold text-gray-900">
                                            GMD {{ number_format($property->base_price) }}
                                        </span>
                                        <span class="text-sm text-gray-600"> / night</span>
                                    </div>
                                    <a href="{{ route('properties.show', $property) }}"
                                       class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No properties found</h3>
                            <p class="mt-1 text-sm text-gray-500">Try adjusting your search filters.</p>
                        </div>
                    @endforelse
                </div>

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