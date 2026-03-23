<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Profile</h1>
                    <p class="text-gray-600 mt-1">Complete your profile to enhance your JubbaStay experience</p>
                </div>
                <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">← Back to Home</a>
            </div>
        </div>

        <form wire:submit="save" class="space-y-6">
            <!-- Profile Type Selection -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Profile Type</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="relative">
                        <input type="radio" wire:model.live="profile_type" value="guest"
                               class="sr-only peer">
                        <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">I'm a Guest</h3>
                                    <p class="text-sm text-gray-600">I want to book properties</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="relative">
                        <input type="radio" wire:model.live="profile_type" value="host"
                               class="sr-only peer">
                        <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">I'm a Host</h3>
                                    <p class="text-sm text-gray-600">I want to list properties</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                @error('profile_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" wire:model="first_name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" wire:model="last_name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" wire:model="phone"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nationality</label>
                        <input type="text" wire:model="nationality"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nationality') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                    <textarea wire:model="bio" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Tell us about yourself..."></textarea>
                    @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                    <input type="file" wire:model="newAvatar" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @if($avatar)
                        <div class="mt-2">
                            <img src="{{ Storage::disk('public')->url($avatar) }}" alt="Current avatar"
                                 class="w-20 h-20 rounded-full object-cover">
                        </div>
                    @endif
                    @error('newAvatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Gambia-Specific Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Gambia-Specific Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Languages Spoken</label>
                        <div class="space-y-2">
                            @foreach($languageOptions as $key => $label)
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="languages" value="{{ $key }}"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('languages') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact</label>
                        <input type="text" wire:model="emergency_contact_name" placeholder="Contact Name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2">
                        <input type="tel" wire:model="emergency_contact_phone" placeholder="Contact Phone"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('emergency_contact_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        @error('emergency_contact_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Guest-Specific Fields -->
            @if($profile_type === 'guest')
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Guest Preferences</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Travel Purpose</label>
                        <select wire:model="travel_purpose" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select purpose</option>
                            <option value="leisure">Leisure/Relaxation</option>
                            <option value="business">Business</option>
                            <option value="cultural">Cultural Experience</option>
                            <option value="adventure">Adventure</option>
                            <option value="family">Family Visit</option>
                            <option value="other">Other</option>
                        </select>
                        @error('travel_purpose') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Group Size Preference</label>
                        <select wire:model="group_size_preference" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select group size</option>
                            <option value="solo">Solo Traveler</option>
                            <option value="couple">Couple</option>
                            <option value="small_group">Small Group (3-5)</option>
                            <option value="large_group">Large Group (6+)</option>
                            <option value="family">Family</option>
                        </select>
                        @error('group_size_preference') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Budget Range (GMD per night)</label>
                        <select wire:model="budget_range" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select budget</option>
                            <option value="budget">Budget (under 500)</option>
                            <option value="mid_range">Mid-range (500-2000)</option>
                            <option value="luxury">Luxury (2000+)</option>
                        </select>
                        @error('budget_range') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Amenities</label>
                        <div class="space-y-2">
                            @foreach($amenityOptions as $key => $label)
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="preferred_amenities" value="{{ $key }}"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('preferred_amenities') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Special Requirements</label>
                    <textarea wire:model="special_requirements" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Any special requirements or preferences..."></textarea>
                    @error('special_requirements') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dietary Restrictions</label>
                        <input type="text" wire:model="dietary_restrictions"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., Vegetarian, Halal, etc.">
                        @error('dietary_restrictions') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Accessibility Needs</label>
                        <input type="text" wire:model="accessibility_needs"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Any accessibility requirements...">
                        @error('accessibility_needs') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            @endif

            <!-- Host-Specific Fields -->
            @if($profile_type === 'host')
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Host Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Years of Hosting Experience</label>
                        <input type="number" wire:model="host_experience_years" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('host_experience_years') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Properties Managed</label>
                        <input type="number" wire:model="properties_managed" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('properties_managed') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Average Response Time (hours)</label>
                        <input type="number" wire:model="response_time_hours" min="0" max="24" step="0.5"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('response_time_hours') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Languages Spoken to Guests</label>
                        <div class="space-y-2">
                            @foreach($languageOptions as $key => $label)
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="languages_spoken" value="{{ $key }}"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('languages_spoken') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Specialties</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($specialtyOptions as $key => $label)
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="specialties" value="{{ $key }}"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('specialties') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Local Knowledge Areas</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="local_knowledge_areas" value="banjul"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Banjul</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="local_knowledge_areas" value="serrekunda"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Serrekunda</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="local_knowledge_areas" value="kotu"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Kotu</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="local_knowledge_areas" value="bijilo"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Bijilo</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="local_knowledge_areas" value="gunjur"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Gunjur</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="local_knowledge_areas" value="serekunda"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Serekunda</span>
                        </label>
                    </div>
                    @error('local_knowledge_areas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            @endif

            <!-- Submit Button -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        @if (session()->has('message'))
                            <div class="text-green-600 font-medium">{{ session('message') }}</div>
                        @endif
                    </div>
                    <button type="submit"
                            class="bg-blue-600 text-white px-8 py-3 rounded-md hover:bg-blue-700 transition-colors font-medium">
                        Save Profile
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>