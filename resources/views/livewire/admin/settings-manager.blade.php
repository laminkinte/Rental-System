<div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-gray-900">Site Settings</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your platform settings from one place</p>
        </div>
        
        <!-- Tabs -->
        <div class="border-b border-gray-100">
            <nav class="flex -mb-px px-4 overflow-x-auto">
                <button wire:click="$set('activeTab', 'general')" 
                    class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap {{ $activeTab === 'general' ? 'border-[#FF385C] text-[#FF385C]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    General
                </button>
                <button wire:click="$set('activeTab', 'branding')" 
                    class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap {{ $activeTab === 'branding' ? 'border-[#FF385C] text-[#FF385C]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Branding
                </button>
                <button wire:click="$set('activeTab', 'locale')" 
                    class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap {{ $activeTab === 'locale' ? 'border-[#FF385C] text-[#FF385C]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Locale
                </button>
                <button wire:click="$set('activeTab', 'booking')" 
                    class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap {{ $activeTab === 'booking' ? 'border-[#FF385C] text-[#FF385C]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Booking
                </button>
                <button wire:click="$set('activeTab', 'fees')" 
                    class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap {{ $activeTab === 'fees' ? 'border-[#FF385C] text-[#FF385C]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Fees
                </button>
                <button wire:click="$set('activeTab', 'social')" 
                    class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap {{ $activeTab === 'social' ? 'border-[#FF385C] text-[#FF385C]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Social
                </button>
                <button wire:click="$set('activeTab', 'seo')" 
                    class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap {{ $activeTab === 'seo' ? 'border-[#FF385C] text-[#FF385C]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    SEO
                </button>
            </nav>
        </div>
        
        <!-- Content -->
        <div class="p-6">
            
            <!-- General Settings -->
            @if($activeTab === 'general')
            <form wire:submit="saveGeneral" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                        <input type="text" wire:model="site_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                        <input type="text" wire:model="tagline" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea wire:model="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" wire:model="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" wire:model="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <input type="text" wire:model="address" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" wire:model="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                        <input type="text" wire:model="country" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF385C] focus:border-transparent">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-[#FF385C] text-white rounded-lg hover:bg-[#E2324A] transition-colors">
                        Save General Settings
                    </button>
                </div>
            </form>
            @endif
            
            <!-- Branding Settings -->
            @if($activeTab === 'branding')
            <form wire:submit="saveBranding" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Primary Color</label>
                        <div class="flex gap-2">
                            <input type="color" wire:model="primary_color" class="h-10 w-20 rounded border border-gray-300 cursor-pointer">
                            <input type="text" wire:model="primary_color" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Secondary Color</label>
                        <div class="flex gap-2">
                            <input type="color" wire:model="secondary_color" class="h-10 w-20 rounded border border-gray-300 cursor-pointer">
                            <input type="text" wire:model="secondary_color" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Accent Color</label>
                        <div class="flex gap-2">
                            <input type="color" wire:model="accent_color" class="h-10 w-20 rounded border border-gray-300 cursor-pointer">
                            <input type="text" wire:model="accent_color" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-[#FF385C] text-white rounded-lg hover:bg-[#E2324A] transition-colors">
                        Save Branding
                    </button>
                </div>
            </form>
            @endif
            
            <!-- Locale Settings -->
            @if($activeTab === 'locale')
            <form wire:submit="saveLocale" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                        <select wire:model="currency" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="USD">USD - US Dollar</option>
                            <option value="EUR">EUR - Euro</option>
                            <option value="GBP">GBP - British Pound</option>
                            <option value="GMD">GMD - Gambian Dalasi</option>
                            <option value="NGN">NGN - Nigerian Naira</option>
                            <option value="KES">KES - Kenyan Shilling</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Currency Symbol</label>
                        <input type="text" wire:model="currency_symbol" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date Format</label>
                        <select wire:model="date_format" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="M d, Y">Mar 18, 2026</option>
                            <option value="d M Y">18 Mar 2026</option>
                            <option value="Y-m-d">2026-03-18</option>
                            <option value="d/m/Y">18/03/2026</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Time Format</label>
                        <select wire:model="time_format" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="h:i A">12:30 PM</option>
                            <option value="H:i">14:30</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Timezone</label>
                        <select wire:model="timezone" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="UTC">UTC</option>
                            <option value="Africa/Banjul">Africa/Banjul (GMT)</option>
                            <option value="America/New_York">America/New_York</option>
                            <option value="Europe/London">Europe/London</option>
                            <option value="Asia/Tokyo">Asia/Tokyo</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                        <select wire:model="language" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="en">English</option>
                            <option value="fr">French</option>
                            <option value="es">Spanish</option>
                            <option value="ar">Arabic</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-[#FF385C] text-white rounded-lg hover:bg-[#E2324A] transition-colors">
                        Save Locale Settings
                    </button>
                </div>
            </form>
            @endif
            
            <!-- Booking Settings -->
            @if($activeTab === 'booking')
            <form wire:submit="saveBooking" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Min Booking Amount</label>
                        <input type="number" wire:model="min_booking_amount" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Booking Amount</label>
                        <input type="number" wire:model="max_booking_amount" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Min Guests</label>
                        <input type="number" wire:model="min_guests" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Guests</label>
                        <input type="number" wire:model="max_guests" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Check-in Time</label>
                        <input type="time" wire:model="default_check_in" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Check-out Time</label>
                        <input type="time" wire:model="default_check_out" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-[#FF385C] text-white rounded-lg hover:bg-[#E2324A] transition-colors">
                        Save Booking Settings
                    </button>
                </div>
            </form>
            @endif
            
            <!-- Fees Settings -->
            @if($activeTab === 'fees')
            <form wire:submit="saveFees" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Service Fee (%)</label>
                        <input type="number" step="0.1" wire:model="service_fee_percent" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Host Fee (%)</label>
                        <input type="number" step="0.1" wire:model="host_fee_percent" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Processing Fee (%)</label>
                        <input type="number" step="0.1" wire:model="payment_processing_fee" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-[#FF385C] text-white rounded-lg hover:bg-[#E2324A] transition-colors">
                        Save Fee Settings
                    </button>
                </div>
            </form>
            @endif
            
            <!-- Social Settings -->
            @if($activeTab === 'social')
            <form wire:submit="saveSocial" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                        <input type="url" wire:model="facebook_url" placeholder="https://facebook.com/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Twitter URL</label>
                        <input type="url" wire:model="twitter_url" placeholder="https://twitter.com/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                        <input type="url" wire:model="instagram_url" placeholder="https://instagram.com/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn URL</label>
                        <input type="url" wire:model="linkedin_url" placeholder="https://linkedin.com/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">YouTube URL</label>
                        <input type="url" wire:model="youtube_url" placeholder="https://youtube.com/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-[#FF385C] text-white rounded-lg hover:bg-[#E2324A] transition-colors">
                        Save Social Settings
                    </button>
                </div>
            </form>
            @endif
            
            <!-- SEO Settings -->
            @if($activeTab === 'seo')
            <form wire:submit="saveSeo" class="space-y-6">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                        <input type="text" wire:model="meta_title" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                        <textarea wire:model="meta_description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                        <input type="text" wire:model="meta_keywords" placeholder="vacation rental, accommodations, travel" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-[#FF385C] text-white rounded-lg hover:bg-[#E2324A] transition-colors">
                        Save SEO Settings
                    </button>
                </div>
            </form>
            @endif
            
            <!-- Reset Button -->
            <div class="mt-8 pt-6 border-t border-gray-100">
                <button wire:click="resetToDefaults" wire:confirm="Are you sure you want to reset all settings to defaults?" 
                    class="text-sm text-gray-500 hover:text-red-500 transition-colors">
                    Reset all settings to defaults
                </button>
            </div>
        </div>
    </div>
</div>
