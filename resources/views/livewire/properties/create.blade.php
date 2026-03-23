<div>
    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input wire:model="title" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Type</label>
                <select wire:model="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="entire_place">Entire Place</option>
                    <option value="private_room">Private Room</option>
                    <option value="shared_room">Shared Room</option>
                    <option value="unique_space">Unique Space</option>
                    <option value="boutique_hotel">Boutique Hotel</option>
                    <option value="serviced_apartment">Serviced Apartment</option>
                </select>
                @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea wire:model="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Guest Capacity</label>
                <input wire:model="guest_capacity" type="number" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('guest_capacity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Bedrooms</label>
                <input wire:model="bedrooms" type="number" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('bedrooms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Bathrooms</label>
                <input wire:model="bathrooms" type="number" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('bathrooms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Address</label>
            <input wire:model="address" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">City</label>
                <input wire:model="city" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Country</label>
                <input wire:model="country" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('country') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Latitude</label>
                <input wire:model="latitude" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('latitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Longitude</label>
                <input wire:model="longitude" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('longitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Base Price</label>
                <input wire:model="base_price" type="number" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('base_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Create Property</button>
        </div>
    </form>

    @if (session()->has('message'))
        <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>

<div>
    {{-- Simplicity is the ultimate sophistication. - Leonardo da Vinci --}}
</div>