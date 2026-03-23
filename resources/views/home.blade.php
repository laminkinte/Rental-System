<x-app-layout>
    <!-- Hero Section - Airbnb Style -->
    <div class="relative bg-gradient-to-br from-[#1a1a1a] to-[#3d3d3d] overflow-hidden">
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 tracking-tight">
                    Find your next stay in
                    <span class="block text-[#FF385C]">The Gambia</span>
                </h1>
                
                <!-- Airbnb-style Search Bar -->
                <div class="max-w-4xl mx-auto mt-10">
                    <form action="{{ route('properties.search') }}" method="GET" class="bg-white rounded-full shadow-xl flex items-center overflow-hidden">
                        <div class="flex-1 px-6 py-4 border-r border-gray-200">
                            <label class="block text-xs font-semibold text-gray-900 uppercase tracking-wide">Location</label>
                            <input type="text" name="search" 
                                   placeholder="Where are you going?" 
                                   class="w-full mt-1 text-gray-700 placeholder-gray-400 focus:outline-none text-sm">
                        </div>
                        <div class="hidden md:block px-6 py-4 border-r border-gray-200">
                            <label class="block text-xs font-semibold text-gray-900 uppercase tracking-wide">Check in</label>
                            <input type="date" name="check_in" 
                                   class="w-full mt-1 text-gray-700 focus:outline-none text-sm">
                        </div>
                        <div class="hidden md:block px-6 py-4 border-r border-gray-200">
                            <label class="block text-xs font-semibold text-gray-900 uppercase tracking-wide">Check out</label>
                            <input type="date" name="check_out" 
                                   class="w-full mt-1 text-gray-700 focus:outline-none text-sm">
                        </div>
                        <div class="px-2 py-2">
                            <button type="submit" 
                                    class="bg-[#FF385C] hover:bg-[#E2324A] text-white rounded-full p-3 transition-colors duration-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Curved divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
            </svg>
        </div>
    </div>

    <!-- Categories Section - Airbnb Style -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
                <a href="{{ route('properties.search') }}" 
                   class="flex-shrink-0 group cursor-pointer">
                    <div class="border-b-2 border-transparent group-hover:border-[#FF385C] pb-3 px-2 transition-colors">
                        <div class="w-10 h-10 mx-auto mb-2 text-2xl">🏠</div>
                        <span class="text-sm font-medium text-gray-900 whitespace-nowrap">All stays</span>
                    </div>
                </a>
                
                <a href="{{ route('properties.search', ['gambia_category' => 'beachfront_villa']) }}" 
                   class="flex-shrink-0 group cursor-pointer">
                    <div class="border-b-2 border-transparent group-hover:border-[#FF385C] pb-3 px-2 transition-colors">
                        <div class="w-10 h-10 mx-auto mb-2 text-2xl">🏖️</div>
                        <span class="text-sm font-medium text-gray-600 whitespace-nowrap">Beachfront</span>
                    </div>
                </a>
                
                <a href="{{ route('properties.search', ['gambia_category' => 'eco_lodge']) }}" 
                   class="flex-shrink-0 group cursor-pointer">
                    <div class="border-b-2 border-transparent group-hover:border-[#FF385C] pb-3 px-2 transition-colors">
                        <div class="w-10 h-10 mx-auto mb-2 text-2xl">🌿</div>
                        <span class="text-sm font-medium text-gray-600 whitespace-nowrap">Eco Lodges</span>
                    </div>
                </a>
                
                <a href="{{ route('properties.search', ['gambia_category' => 'cultural_homestay']) }}" 
                   class="flex-shrink-0 group cursor-pointer">
                    <div class="border-b-2 border-transparent group-hover:border-[#FF385C] pb-3 px-2 transition-colors">
                        <div class="w-10 h-10 mx-auto mb-2 text-2xl">🏡</div>
                        <span class="text-sm font-medium text-gray-600 whitespace-nowrap">Homestays</span>
                    </div>
                </a>
                
                <a href="{{ route('properties.search', ['gambia_category' => 'boutique_hotel']) }}" 
                   class="flex-shrink-0 group cursor-pointer">
                    <div class="border-b-2 border-transparent group-hover:border-[#FF385C] pb-3 px-2 transition-colors">
                        <div class="w-10 h-10 mx-auto mb-2 text-2xl">🏨</div>
                        <span class="text-sm font-medium text-gray-600 whitespace-nowrap">Hotels</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Featured Properties Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Featured stays</h2>
                <a href="{{ route('properties.search') }}" class="text-sm font-semibold text-[#FF385C] hover:text-[#E2324A]">
                    Show all →
                </a>
            </div>

            @livewire('home')
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">JubbaStay Gambia</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-[#FF385C] bg-opacity-10 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-[#FF385C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Verified Properties</h3>
                    <p class="text-gray-600">Every listing is verified for quality and safety standards</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Local Payments</h3>
                    <p class="text-gray-600">Pay with local currency and trusted Gambian payment options</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">24/7 Support</h3>
                    <p class="text-gray-600">Get help in your language with our local support team</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
