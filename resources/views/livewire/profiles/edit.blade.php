<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Edit Profile</h1>
                <p class="text-gray-600 mt-1">Manage your account settings and preferences</p>
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button wire:click="$set('activeTab', 'basic')" 
                        class="px-6 py-3 border-b-2 {{ $activeTab === 'basic' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        Basic Info
                    </button>
                    <button wire:click="$set('activeTab', 'host')" 
                        class="px-6 py-3 border-b-2 {{ $activeTab === 'host' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        Become a Host
                    </button>
                </nav>
            </div>

            <!-- Content -->
            <div class="p-6">
                @if($activeTab === 'basic')
                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" wire:model="name" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" wire:model="email" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="text" wire:model="phone" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                <input type="text" wire:model="username" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Country -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                <select wire:model="country" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                    <option value="">Select country</option>
                                    <option value="Gambia">The Gambia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="USA">United States</option>
                                    <option value="Germany">Germany</option>
                                    <option value="France">France</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('country') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Bio -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                <textarea wire:model="bio" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                                    placeholder="Tell us about yourself..."></textarea>
                                @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Preferred Language -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Language</label>
                                <select wire:model="preferred_language" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                    <option value="en">English</option>
                                    <option value="wo">Wolof</option>
                                    <option value="fr">French</option>
                                    <option value="de">German</option>
                                </select>
                            </div>

                            <!-- Preferred Currency -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Currency</label>
                                <select wire:model="preferred_currency" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                    <option value="GMD">GMD - Dalasi</option>
                                    <option value="USD">USD - US Dollar</option>
                                    <option value="EUR">EUR - Euro</option>
                                    <option value="GBP">GBP - British Pound</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" 
                                class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </form>
                @endif

                @if($activeTab === 'host')
                    <div class="space-y-6">
                        @if($is_host)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                <div class="flex items-center mb-4">
                                    <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-green-800">You're a Host!</h3>
                                </div>
                                <p class="text-green-700 mb-4">You can now list properties and start earning.</p>
                                <div class="flex gap-3">
                                    <a href="{{ route('properties.create') }}" 
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                                        List a Property
                                    </a>
                                    <a href="{{ route('host.dashboard') }}" 
                                        class="bg-white border border-green-600 text-green-600 px-4 py-2 rounded-lg font-medium hover:bg-green-50">
                                        Host Dashboard
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-lg p-6 text-white">
                                <h3 class="text-xl font-bold mb-2">🌟 Become a Host</h3>
                                <p class="text-amber-100 mb-4">Share your property and earn extra income. Join thousands of hosts in The Gambia!</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                    <div class="bg-white/20 rounded-lg p-4 text-center">
                                        <div class="text-2xl mb-2">💰</div>
                                        <div class="font-semibold">Earn Money</div>
                                        <div class="text-sm text-amber-100">Set your own prices</div>
                                    </div>
                                    <div class="bg-white/20 rounded-lg p-4 text-center">
                                        <div class="text-2xl mb-2">🏠</div>
                                        <div class="font-semibold">Share Gambia</div>
                                        <div class="text-sm text-amber-100">Meet travelers</div>
                                    </div>
                                    <div class="bg-white/20 rounded-lg p-4 text-center">
                                        <div class="text-2xl mb-2">📅</div>
                                        <div class="font-semibold">Flexible</div>
                                        <div class="text-sm text-amber-100">Host when you want</div>
                                    </div>
                                </div>

                                <button wire:click="becomeHost" 
                                    class="bg-white text-orange-600 px-6 py-3 rounded-lg font-bold hover:bg-amber-50 transition-colors">
                                    Become a Host Now
                                </button>
                            </div>

                            <!-- Optional: Host details -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="font-semibold text-gray-800 mb-4">Host Details (Optional)</h4>
                                <p class="text-gray-600 text-sm mb-4">You can add more details about your hosting experience after becoming a host.</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Years of Hosting</label>
                                        <input type="number" wire:model="host_experience_years" min="0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Response Time</label>
                                        <select wire:model="host_response_time"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">
                                            <option value="within_an_hour">Within an hour</option>
                                            <option value="within_a_day">Within a day</option>
                                            <option value="within_a_week">Within a week</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
