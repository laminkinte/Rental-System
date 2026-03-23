<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Properties</h1>
                <p class="text-gray-600 mt-1">Manage your {{ Auth::user()->isAdmin() ? 'all' : '' }} property listings</p>
            </div>
            <a href="{{ route('properties.create') }}" class="px-6 py-3 bg-[#FF385C] text-white font-semibold rounded-xl hover:bg-[#E2324A] transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Property
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" wire:model.live.debounce.300ms="search" 
                        placeholder="Search properties..." 
                        class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                </div>
                <select wire:model.live="status" class="px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <!-- Properties Grid -->
        @if($properties->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($properties as $property)
            <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg transition-all">
                <!-- Image -->
                <div class="relative aspect-[4/3] bg-gray-200">
                    @php $images = $property->images; @endphp
                    @if(is_array($images) && count($images) > 0)
                        <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        @if($property->is_active)
                            <span class="bg-green-500 text-white text-xs font-medium px-2 py-1 rounded">Active</span>
                        @else
                            <span class="bg-gray-500 text-white text-xs font-medium px-2 py-1 rounded">Inactive</span>
                        @endif
                    </div>
                    
                    <!-- Verified Badge -->
                    @if($property->verified_listing)
                    <div class="absolute top-3 left-3">
                        <span class="bg-blue-500 text-white text-xs font-medium px-2 py-1 rounded flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Verified
                        </span>
                    </div>
                    @endif
                </div>
                
                <!-- Content -->
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 truncate mb-1">{{ $property->title }}</h3>
                    <p class="text-sm text-gray-500 mb-2">{{ $property->city }}, {{ $property->country }}</p>
                    
                    <div class="flex items-center justify-between text-sm text-gray-600 mb-3">
                        <span>{{ $property->bedrooms ?? 1 }} beds</span>
                        <span>{{ $property->bathrooms ?? 1 }} baths</span>
                        <span>{{ $property->guest_capacity ?? 2 }} guests</span>
                    </div>
                    
                    <div class="flex items-baseline gap-1 mb-4">
                        <span class="text-lg font-bold text-gray-900">${{ number_format($property->base_price ?? 50) }}</span>
                        <span class="text-sm text-gray-600">/ night</span>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex gap-2">
                        <a href="{{ route('properties.show', $property) }}" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 text-center rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                            View
                        </a>
                        <a href="{{ route('properties.create') }}?edit={{ $property->id }}" class="flex-1 px-4 py-2 bg-[#FF385C] text-white text-center rounded-lg hover:bg-[#E2324A] transition-colors text-sm font-medium">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($properties->hasPages())
        <div class="mt-8">
            {{ $properties->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-12 bg-white rounded-2xl border border-gray-100">
            <div class="text-6xl mb-4">🏠</div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No properties found</h3>
            <p class="text-gray-600 mb-6">Start by adding your first property</p>
            <a href="{{ route('properties.create') }}" class="inline-block px-6 py-3 bg-[#FF385C] text-white font-semibold rounded-xl hover:bg-[#E2324A] transition-colors">
                Add Property
            </a>
        </div>
        @endif
    </div>
</div>
