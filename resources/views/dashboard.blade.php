<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600 mt-2">Manage your bookings and explore new destinations in The Gambia.</p>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <a href="{{ route('properties.search') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition text-center">
                    <div class="text-4xl mb-3">🔍</div>
                    <div class="font-semibold text-gray-900">Find Properties</div>
                    <p class="text-sm text-gray-500 mt-1">Search for your next stay</p>
                </a>

                <a href="{{ route('bookings.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition text-center">
                    <div class="text-4xl mb-3">📋</div>
                    <div class="font-semibold text-gray-900">My Bookings</div>
                    <p class="text-sm text-gray-500 mt-1">View your reservations</p>
                </a>

                <a href="{{ route('wallet.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition text-center">
                    <div class="text-4xl mb-3">💰</div>
                    <div class="font-semibold text-gray-900">Wallet</div>
                    <p class="text-sm text-gray-500 mt-1">Manage payments</p>
                </a>

                <a href="{{ route('messages.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition text-center">
                    <div class="text-4xl mb-3">💬</div>
                    <div class="font-semibold text-gray-900">Messages</div>
                    <p class="text-sm text-gray-500 mt-1">Chat with hosts</p>
                </a>
            </div>

            <!-- Featured Properties -->
            <div class="bg-white rounded-lg shadow mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Popular Destinations in The Gambia</h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4">Explore our curated selection of amazing properties:</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('properties.search') }}?category=beachfront_villa" class="block bg-gradient-to-r from-blue-500 to-teal-500 rounded-lg p-6 text-white hover:opacity-90 transition">
                            <div class="font-semibold text-xl">🏖️ Beachfront Villas</div>
                            <p class="text-sm mt-2 text-blue-100">Wake up to ocean views</p>
                        </a>
                        <a href="{{ route('properties.search') }}?category=apartments" class="block bg-gradient-to-r from-green-500 to-teal-500 rounded-lg p-6 text-white hover:opacity-90 transition">
                            <div class="font-semibold text-xl">🏠 Apartments</div>
                            <p class="text-sm mt-2 text-green-100">Urban living at its best</p>
                        </a>
                        <a href="{{ route('properties.search') }}?category=resorts" class="block bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg p-6 text-white hover:opacity-90 transition">
                            <div class="font-semibold text-xl">🏨 Resorts</div>
                            <p class="text-sm mt-2 text-purple-100">Luxury and relaxation</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Become a Host CTA (for non-hosts) -->
            @if(!Auth::user()->is_host)
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-lg shadow mb-8">
                <div class="px-6 py-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-white">Become a Host</h2>
                        <p class="text-amber-100 mt-1">Share your property and earn extra income in The Gambia</p>
                    </div>
                    <a href="{{ route('properties.create') }}" class="bg-white text-orange-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Get Started
                    </a>
                </div>
            </div>
            @endif

            <!-- Help & Support -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Need Help?</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-2xl mb-2">📞</div>
                            <div class="font-medium text-gray-900">Contact Support</div>
                            <p class="text-sm text-gray-500">We're here to help 24/7</p>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl mb-2">📖</div>
                            <div class="font-medium text-gray-900">Help Center</div>
                            <p class="text-sm text-gray-500">FAQs and guides</p>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl mb-2">⭐</div>
                            <div class="font-medium text-gray-900">Leave a Review</div>
                            <p class="text-sm text-gray-500">Share your experience</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
