<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Create a Listing</h1>
            @php
                $stepTitles = [
                    1 => 'Property Type & Capacity',
                    2 => 'Location',
                    3 => 'Photos',
                    4 => 'Amenities',
                    5 => 'Availability',
                    6 => 'Pricing',
                    7 => 'Details & Policies',
                ];
            @endphp
            <p class="text-gray-600 mt-2">Step {{ $currentStep }} of {{ $totalSteps }}: {{ $stepTitles[$currentStep] ?? 'Unknown' }}</p>
            <div class="mt-4 bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full transition-all" style="width: {{ ($currentStep / $totalSteps) * 100 }}%; display: block;"></div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <form wire:submit.prevent="submit" class="space-y-6">
                <!-- Step 1: Basic Details -->
                @if($currentStep === 1)
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold">Property Type & Capacity</h2>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Property Type</label>
                            <select wire:model="type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                                <option value="">Select a type</option>
                                <option value="entire_place">Entire Place</option>
                                <option value="private_room">Private Room</option>
                                <option value="shared_room">Shared Room</option>
                                <option value="unique_space">Unique Space</option>
                                <option value="boutique_hotel">Boutique Hotel</option>
                                <option value="serviced_apartment">Serviced Apartment</option>
                            </select>
                            @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Guests</label>
                                <input type="number" wire:model.live="guest_capacity" min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                                @error('guest_capacity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Bedrooms</label>
                                <input type="number" wire:model.live="bedrooms" min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                                @error('bedrooms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Bathrooms</label>
                                <input type="number" wire:model.live="bathrooms" min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                                @error('bathrooms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Property Size (m²)</label>
                            <input type="number" wire:model="size_sqm" min="1" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>
                    </div>
                @endif

                <!-- Step 2: Location -->
                @if($currentStep === 2)
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold">Location Details</h2>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Street Address</label>
                            <input type="text" wire:model="address" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3" placeholder="123 Main Street">
                            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" wire:model="city" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3" placeholder="Banjul">
                            @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Latitude</label>
                                <input type="number" step="0.000001" wire:model="latitude" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3" placeholder="13.443182">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Longitude</label>
                                <input type="number" step="0.000001" wire:model="longitude" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3" placeholder="-15.310139">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Location Privacy</label>
                            <select wire:model="location_privacy" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                                <option value="exact">Exact Address</option>
                                <option value="city">City Only</option>
                                <option value="region">Region Only</option>
                            </select>
                        </div>
                    </div>
                @endif

                <!-- Step 3: Media -->
                @if($currentStep === 3)
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold">Upload Photos</h2>
                        <p class="text-sm text-gray-600">Add at least 5 high-quality photos of your property.</p>

                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                            <input type="file" wire:model="uploadedPhotos" multiple accept="image/*" class="w-full">
                            <p class="text-sm text-gray-500 mt-2">Or drag and drop images here</p>
                        </div>

                        @if($uploadedPhotos)
                            <button type="button" wire:click="uploadPhotos" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Upload Photos</button>
                        @endif

                        <div class="grid grid-cols-3 gap-4 mt-4">
                            @foreach($photos as $photo)
                                <div class="relative">
                                    <img src="{{ $photo }}" alt="Property photo" class="w-full h-32 object-cover rounded-lg">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Step 4: Amenities -->
                @if($currentStep === 4)
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold">Select Amenities</h2>

                        <div class="grid grid-cols-2 gap-4">
                            @php
                                $amenityOptions = [
                                    'wifi' => 'WiFi',
                                    'kitchen' => 'Kitchen',
                                    'parking' => 'Parking',
                                    'washing_machine' => 'Washing Machine',
                                    'pool' => 'Swimming Pool',
                                    'air_conditioning' => 'Air Conditioning',
                                    'heating' => 'Heating',
                                    'tv' => 'TV',
                                    'workspace' => 'Dedicated Workspace',
                                    'balcony' => 'Balcony/Terrace',
                                    'garden' => 'Garden',
                                    'gym' => 'Gym',
                                ];
                            @endphp
                            @foreach($amenityOptions as $key => $label)
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="amenities" value="{{ $key }}" class="rounded">
                                    <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Step 5: Availability -->
                @if($currentStep === 5)
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold">Availability & Check-In</h2>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Minimum Stay (nights)</label>
                                <input type="number" wire:model="min_stay" min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Maximum Stay (nights)</label>
                                <input type="number" wire:model="max_stay" min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Check-in Time</label>
                                <input type="time" wire:model="check_in_time" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Check-out Time</label>
                                <input type="time" wire:model="check_out_time" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="early_check_in" class="rounded">
                                <span class="ml-2 text-sm text-gray-700">Allow early check-in (when available)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="late_check_out" class="rounded">
                                <span class="ml-2 text-sm text-gray-700">Allow late check-out (when available)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="self_check_in" class="rounded">
                                <span class="ml-2 text-sm text-gray-700">Allow self check-in (keybox, digital lock)</span>
                            </label>
                        </div>
                    </div>
                @endif

                <!-- Step 6: Pricing -->
                @if($currentStep === 6)
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold">Set Your Prices</h2>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Base Price (per night, GMD)</label>
                            <input type="number" wire:model="base_price" min="0" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            @error('base_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cleaning Fee (GMD)</label>
                                <input type="number" wire:model="cleaning_fee" min="0" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Extra Guest Fee (GMD)</label>
                                <input type="number" wire:model="extra_guest_fee" min="0" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Weekly Discount (%)</label>
                                <input type="number" wire:model="weekly_discount" min="0" max="100" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Monthly Discount (%)</label>
                                <input type="number" wire:model="monthly_discount" min="0" max="100" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Security Deposit (GMD)</label>
                            <input type="number" wire:model="security_deposit" min="0" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <label class="flex items-center">
                            <input type="checkbox" wire:model="instant_book" class="rounded">
                            <span class="ml-2 text-sm text-gray-700">Allow instant booking (guests can book without approval)</span>
                        </label>
                    </div>
                @endif

                <!-- Step 7: Rules & Policies -->
                @if($currentStep === 7)
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold">Title, Description & Rules</h2>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Listing Title</label>
                            <input type="text" wire:model="title" maxlength="255" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3" placeholder="Cozy Beachfront Villa in Kololi">
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea wire:model="description" rows="6" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3" placeholder="Describe your property..."></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cancellation Policy</label>
                            <select wire:model="cancellation_policy" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                                <option value="flexible">Flexible (Full refund up to 7 days before)</option>
                                <option value="moderate">Moderate (Full refund up to 14 days before)</option>
                                <option value="strict">Strict (Full refund up to 30 days before)</option>
                                <option value="non_refundable">Non-refundable</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pet Policy</label>
                                <select wire:model="pet_policy" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                                    <option value="allowed">Allowed</option>
                                    <option value="not_allowed">Not Allowed</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Smoking Policy</label>
                                <select wire:model="smoking_policy" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                                    <option value="allowed">Allowed</option>
                                    <option value="not_allowed">Not Allowed</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">House Rules</label>
                            <textarea wire:model="house_rules" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3" placeholder="E.g., No noise after 10pm, No parties..."></textarea>
                        </div>
                    </div>
                @endif

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8">
                    @if($currentStep > 1)
                        <button type="button" wire:click="previousStep" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">← Previous</button>
                    @else
                        <div></div>
                    @endif

                    @if($currentStep < $totalSteps)
                        <button type="button" wire:click="nextStep" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Next →</button>
                    @else
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Create Property</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
