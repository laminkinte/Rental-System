<div>
    <!-- Search Filters -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Search</label>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Property title..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Type</label>
                <select wire:model.live="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">All Types</option>
                    <option value="entire_place">Entire Place</option>
                    <option value="private_room">Private Room</option>
                    <option value="shared_room">Shared Room</option>
                    <option value="unique_space">Unique Space</option>
                    <option value="boutique_hotel">Boutique Hotel</option>
                    <option value="serviced_apartment">Serviced Apartment</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">City</label>
                <input wire:model.live.debounce.300ms="city" type="text" placeholder="City..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Guests</label>
                <input wire:model.live="guests" type="number" placeholder="Number of guests..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
        </div>
    </div>

    <!-- Properties Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($properties as $property)
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">Property Image</span>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $property->title }}</h3>
                    <p class="text-gray-600 text-sm">{{ $property->city }}, {{ $property->country }}</p>
                    <p class="text-gray-800 font-medium mt-2">${{ $property->base_price }} / night</p>
                    <p class="text-sm text-gray-500">Up to {{ $property->guest_capacity }} guests</p>
                    <a href="#" class="mt-3 inline-block bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">View Details</a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $properties->links() }}
    </div>

    @if($properties->isEmpty())
        <p class="text-center text-gray-500 mt-6">No properties found matching your criteria.</p>
    @endif
</div>

<div>
    {{-- You must be the change you wish to see in the world. - Mahatma Gandhi --}}
</div>