<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-[#FF385C] to-[#FF5A5F] text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">
                    {{ $siteName }}
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-90">
                    {{ $tagline }}
                </p>
                
                <!-- Search Box -->
                <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-4 mt-8">
                    <form wire:submit="search" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Where do you want to stay?</label>
                            <input type="text" wire:model="heroLocation" placeholder="Search destinations..." class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-800 focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                        </div>
                        <div class="w-full md:w-44">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Check-in</label>
                            <input type="date" wire:model="heroCheckIn" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-800 focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                        </div>
                        <div class="w-full md:w-44">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Check-out</label>
                            <input type="date" wire:model="heroCheckOut" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-800 focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                        </div>
                        <div class="w-full md:w-36">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Guests</label>
                            <select wire:model="heroGuests" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-800 focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                                <option value="">Any</option>
                                @for($i = 1; $i <= 16; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'guest' : 'guests' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full md:w-auto px-8 py-3 bg-[#FF385C] hover:bg-[#E2324A] text-white font-semibold rounded-xl transition-colors flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stats Section -->
    <div class="bg-white py-12 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-3xl font-bold text-[#FF385C]">{{ $stats['properties'] }}</div>
                    <div class="text-gray-500 text-sm mt-1">Properties</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-[#FF385C]">{{ $stats['guests'] }}</div>
                    <div class="text-gray-500 text-sm mt-1">Happy Guests</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-[#FF385C]">{{ $stats['hosts'] }}</div>
                    <div class="text-gray-500 text-sm mt-1">Host Partners</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-[#FF385C]">{{ number_format($stats['rating'], 1) }} ⭐</div>
                    <div class="text-gray-500 text-sm mt-1">Average Rating</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Categories Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Browse by category</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($categories as $category)
                <a href="{{ route('properties.search', ['category' => strtolower(str_replace(' ', '_', $category['name']))]) }}" class="bg-white rounded-xl p-6 text-center hover:shadow-lg transition-shadow border border-gray-100">
                    <div class="text-4xl mb-3">{{ $category['icon'] }}</div>
                    <div class="font-semibold text-gray-900 text-sm">{{ $category['name'] }}</div>
                    <div class="text-xs text-gray-500 mt-1">{{ $category['count'] }} listings</div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Featured Properties -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Featured stays</h2>
                <a href="{{ route('properties.search') }}" class="text-[#FF385C] hover:underline font-medium">View all →</a>
            </div>
            
            @if($featuredProperties->isEmpty())
                <div class="text-center py-12 bg-gray-50 rounded-2xl">
                    <div class="text-6xl mb-4">🏠</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No properties yet</h3>
                    <p class="text-gray-600 mb-4">Be the first to list your property in The Gambia!</p>
                    <a href="{{ route('properties.create') }}" class="inline-block bg-[#FF385C] hover:bg-[#E2324A] text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                        List your property
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($featuredProperties as $property)
                    <a href="{{ route('properties.show', $property) }}" class="group">
                        <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
                            <!-- Image -->
                            <div class="relative aspect-[4/3] overflow-hidden bg-gray-200">
                                @php
                                    $images = is_string($property->images) ? json_decode($property->images, true) : ($property->images ?? []);
                                @endphp
                                @if($images && count($images) > 0)
                                    <img src="{{ asset('storage/' . $images[0]) }}" 
                                         alt="{{ $property->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                        <span class="text-6xl">🏡</span>
                                    </div>
                                @endif
                                
                                <!-- Wishlist -->
                                <button class="absolute top-3 right-3 p-2 rounded-full bg-white/90 hover:bg-white transition-colors shadow">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                                
                                <!-- Category Badge -->
                                @if($property->gambia_category)
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-black/70 text-white text-xs font-medium px-2 py-1 rounded-lg backdrop-blur-sm">
                                            {{ ucfirst(str_replace('_', ' ', $property->gambia_category)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="p-4">
                                <div class="flex items-start justify-between mb-1">
                                    <h3 class="font-semibold text-gray-900 truncate flex-1 pr-2">{{ $property->title }}</h3>
                                    @if($property->quality_score >= 4.5)
                                        <div class="flex items-center gap-1 text-sm">
                                            <svg class="w-4 h-4 text-[#FF385C]" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="font-medium">{{ number_format($property->quality_score, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <p class="text-sm text-gray-500 mb-2 truncate">{{ $property->city ?? 'The Gambia' }}</p>
                                
                                <div class="flex items-center gap-2 text-xs text-gray-600 mb-3">
                                    <span>{{ $property->bedrooms ?? 1 }} bed{{ ($property->bedrooms ?? 1) > 1 ? 's' : '' }}</span>
                                    <span>·</span>
                                    <span>{{ $property->bathrooms ?? 1 }} bath{{ ($property->bathrooms ?? 1) > 1 ? 's' : '' }}</span>
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
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-[#00A699] to-[#00D1B2] text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Become a Host</h2>
            <p class="text-xl mb-8 opacity-90">Share your space and earn extra income</p>
            <a href="{{ route('properties.create') }}" class="inline-block bg-white text-[#00A699] hover:bg-gray-100 px-8 py-4 rounded-xl font-semibold transition-colors">
                Start hosting today
            </a>
        </div>
    </div>
</div>
