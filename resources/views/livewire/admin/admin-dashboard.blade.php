<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white sticky top-0 z-50 shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl font-bold text-white">JubbaStay</span>
                            <span class="block text-xs text-pink-400 font-medium">Admin Panel</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-1">
                    <button wire:click="setTab('overview')" class="px-4 py-2 rounded-lg text-sm font-medium transition-all flex items-center gap-2 {{ $selectedMetric === 'overview' ? 'bg-pink-500 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dashboard
                    </button>
                    <button wire:click="setTab('users')" class="px-4 py-2 rounded-lg text-sm font-medium transition-all flex items-center gap-2 {{ $selectedMetric === 'users' ? 'bg-pink-500 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Users
                    </button>
                    <button wire:click="setTab('properties')" class="px-4 py-2 rounded-lg text-sm font-medium transition-all flex items-center gap-2 {{ $selectedMetric === 'properties' ? 'bg-pink-500 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Properties
                    </button>
                    <button wire:click="setTab('bookings')" class="px-4 py-2 rounded-lg text-sm font-medium transition-all flex items-center gap-2 {{ $selectedMetric === 'bookings' ? 'bg-pink-500 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Bookings
                    </button>
                    <button wire:click="setTab('settings')" class="px-4 py-2 rounded-lg text-sm font-medium transition-all flex items-center gap-2 {{ $selectedMetric === 'settings' ? 'bg-pink-500 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Settings
                    </button>
                    <a href="{{ route('admin.reports') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all flex items-center gap-2 text-gray-300 hover:bg-gray-700 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Reports
                    </a>
</nav>

                <!-- Right side: Notifications & User menu -->
                <div class="flex items-center gap-4">
                    <!-- Notifications -->
                    <button class="relative p-2 text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if(($metrics['fraudAlertsCount'] ?? 0) > 0)
                            <span class="absolute top-1 right-1 w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
                        @endif
                    </button>

                    <!-- User menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-3 bg-gray-800 px-3 py-2 rounded-xl hover:bg-gray-700 transition">
                            <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-rose-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-sm">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                            </div>
                            <span class="hidden md:block text-sm font-medium">{{ auth()->user()->name ?? 'Admin' }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak
                             x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 overflow-hidden">
                            <div class="p-4 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'Admin' }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'admin@jubbastay.com' }}</p>
                            </div>
                            <div class="p-2">
                                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    Back to Website
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
                    <p class="text-gray-500 mt-1">Welcome back! Here's what's happening with your platform.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-200 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-sm font-medium text-gray-600">{{ now()->format('l, M j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Bookings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">+12%</span>
                </div>
                <p class="text-sm text-gray-500 mb-1">Total Bookings</p>
                <p class="text-3xl font-bold text-gray-900">{{ $metrics['bookingsCount'] ?? 0 }}</p>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <p class="text-sm text-gray-500">Revenue</p>
                    <p class="text-lg font-bold text-green-600">${{ number_format($metrics['revenue'] ?? 0, 2) }}</p>
                </div>
            </div>

            <!-- Total Users -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">+8%</span>
                </div>
                <p class="text-sm text-gray-500 mb-1">Total Users</p>
                <p class="text-3xl font-bold text-gray-900">{{ $metrics['usersCount'] ?? 0 }}</p>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <p class="text-sm text-gray-500">This Month</p>
                    <p class="text-lg font-bold text-emerald-600">{{ $metrics['usersCount'] ?? 0 }} new</p>
                </div>
            </div>

            <!-- Average Rating -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </div>
                    <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-full flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        {{ number_format($metrics['avgRating'] ?? 0, 1) }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 mb-1">Average Rating</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($metrics['avgRating'] ?? 0, 1) }}<span class="text-lg text-gray-400">/5</span></p>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <div class="flex gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= round($metrics['avgRating'] ?? 0) ? 'text-amber-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Fraud Alerts -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    @if(($metrics['fraudAlertsCount'] ?? 0) > 0)
                        <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded-full animate-pulse">Alert!</span>
                    @else
                        <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">All Clear</span>
                    @endif
                </div>
                <p class="text-sm text-gray-500 mb-1">Fraud Alerts</p>
                <p class="text-3xl font-bold text-gray-900">{{ $metrics['fraudAlertsCount'] ?? 0 }}</p>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <p class="text-sm text-gray-500">Flagged Transactions</p>
                    <a href="#" class="text-sm font-medium text-pink-600 hover:text-pink-700">View Details →</a>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="border-b border-gray-100">
                <div class="flex overflow-x-auto">
                    <button wire:click="setTab('overview')" 
                        class="px-6 py-4 font-medium text-sm transition-all whitespace-nowrap flex items-center gap-2 {{ $selectedMetric === 'overview' ? 'text-pink-600 border-b-2 border-pink-500 bg-pink-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Overview
                    </button>
                    <button wire:click="setTab('fraud')" 
                        class="px-6 py-4 font-medium text-sm transition-all whitespace-nowrap flex items-center gap-2 {{ $selectedMetric === 'fraud' ? 'text-pink-600 border-b-2 border-pink-500 bg-pink-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Fraud Detection
                        @if(is_object($suspicious) && method_exists($suspicious, 'total') && $suspicious->total() > 0)
                            <span class="bg-red-100 text-red-600 text-xs px-2 py-0.5 rounded-full">{{ $suspicious->total() }}</span>
                        @endif
                    </button>
                    <button wire:click="setTab('disputes')" 
                        class="px-6 py-4 font-medium text-sm transition-all whitespace-nowrap flex items-center gap-2 {{ $selectedMetric === 'disputes' ? 'text-pink-600 border-b-2 border-pink-500 bg-pink-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Disputes
                    </button>
                    <button wire:click="setTab('payouts')" 
                        class="px-6 py-4 font-medium text-sm transition-all whitespace-nowrap flex items-center gap-2 {{ $selectedMetric === 'payouts' ? 'text-pink-600 border-b-2 border-pink-500 bg-pink-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Payouts
                    </button>
                    <button wire:click="setTab('activity')" 
                        class="px-6 py-4 font-medium text-sm transition-all whitespace-nowrap flex items-center gap-2 {{ $selectedMetric === 'activity' ? 'text-pink-600 border-b-2 border-pink-500 bg-pink-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Activity Log
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Overview Tab -->
                @if($selectedMetric === 'overview')
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Quick Stats -->
                        <div class="lg:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Platform Performance</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 text-center">
                                    <p class="text-2xl font-bold text-blue-600">{{ $metrics['bookingsCount'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Total Bookings</p>
                                </div>
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 text-center">
                                    <p class="text-2xl font-bold text-green-600">${{ number_format($metrics['revenue'] ?? 0, 0) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Total Revenue</p>
                                </div>
                                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 text-center">
                                    <p class="text-2xl font-bold text-purple-600">{{ $metrics['usersCount'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Active Users</p>
                                </div>
                                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 text-center">
                                    <p class="text-2xl font-bold text-amber-600">{{ number_format($metrics['avgRating'] ?? 0, 1) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Avg Rating</p>
                                </div>
                            </div>

                            <!-- Recent Bookings Table -->
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Bookings</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <th class="pb-3">Booking ID</th>
                                            <th class="pb-3">Guest</th>
                                            <th class="pb-3">Property</th>
                                            <th class="pb-3">Dates</th>
                                            <th class="pb-3">Amount</th>
                                            <th class="pb-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @php
                                            $recentBookings = \App\Models\Booking::with(['user', 'property'])->latest()->take(5)->get();
                                        @endphp
                                        @forelse($recentBookings as $booking)
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-3 text-sm font-medium text-gray-900">#{{ $booking->id }}</td>
                                                <td class="py-3 text-sm text-gray-600">{{ $booking->user->name ?? 'N/A' }}</td>
                                                <td class="py-3 text-sm text-gray-600">{{ $booking->property->title ?? 'N/A' }}</td>
                                                <td class="py-3 text-sm text-gray-600">{{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('M j') : 'N/A' }} - {{ $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('M j') : 'N/A' }}</td>
                                                <td class="py-3 text-sm font-medium text-gray-900">${{ number_format($booking->total_amount ?? $booking->total_price ?? 0, 2) }}</td>
                                                <td class="py-3">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="py-8 text-center text-gray-500">No bookings yet</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Quick Actions & Recent Users -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <button wire:click="setTab('users')" class="w-full flex items-center gap-3 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition text-left">
                                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Manage Users</p>
                                        <p class="text-sm text-gray-500">View and edit user accounts</p>
                                    </div>
                                </button>
                                <button wire:click="setTab('properties')" class="w-full flex items-center gap-3 p-4 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition text-left">
                                    <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Properties</p>
                                        <p class="text-sm text-gray-500">Review listings and content</p>
                                    </div>
                                </button>
                                <button wire:click="setTab('settings')" class="w-full flex items-center gap-3 p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition text-left">
                                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Settings</p>
                                        <p class="text-sm text-gray-500">Platform configuration</p>
                                    </div>
                                </button>
                            </div>

                            <!-- Recent Users -->
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 mt-6">Recent Users</h3>
                            <div class="space-y-3">
                                @php
                                    $recentUsers = \App\Models\User::latest()->take(5)->get();
                                @endphp
                                @forelse($recentUsers as $user)
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                                        <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ substr($user->name ?? 'U', 0, 1) }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-gray-900 truncate">{{ $user->name ?? 'User' }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->email ?? '' }}</p>
                                        </div>
                                        <span class="text-xs font-medium text-gray-500 bg-gray-200 px-2 py-1 rounded">{{ $user->role ?? 'user' }}</span>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm text-center py-4">No users yet</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Fraud Detection Tab -->
                @if($selectedMetric === 'fraud')
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Suspicious Transactions</h3>
                                <p class="text-sm text-gray-500">Review and manage flagged payments</p>
                            </div>
                        @if(is_object($suspicious) && method_exists($suspicious, 'total') && $suspicious->total() > 0)
                            <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-full">{{ $suspicious->total() }} flagged</span>
                        @endif
                        </div>
                        
                        @if(is_object($suspicious) && $suspicious->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <th class="pb-3">User</th>
                                            <th class="pb-3">Email</th>
                                            <th class="pb-3">Amount</th>
                                            <th class="pb-3">Risk Score</th>
                                            <th class="pb-3">Reason</th>
                                            <th class="pb-3">Date</th>
                                            <th class="pb-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($suspicious as $payment)
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-3">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                                            <span class="text-gray-600 text-xs font-medium">{{ substr($payment->user->name ?? 'U', 0, 1) }}</span>
                                                        </div>
                                                        <span class="font-medium text-gray-900">{{ $payment->user->name ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 text-sm text-gray-600">{{ $payment->user->email ?? 'N/A' }}</td>
                                                <td class="py-3 text-sm font-bold text-gray-900">${{ number_format($payment->amount ?? 0, 2) }}</td>
                                                <td class="py-3">
                                                    @php $score = $payment->fraud_score['score'] ?? 0; @endphp
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $score > 70 ? 'bg-red-100 text-red-800' : ($score > 40 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                        {{ $score }}%
                                                    </span>
                                                </td>
                                                <td class="py-3 text-sm text-gray-600 max-w-xs truncate">
                                                    {{ implode(', ', $payment->fraud_score['reasons'] ?? ['No issues']) }}
                                                </td>
                                                <td class="py-3 text-sm text-gray-500">{{ $payment->created_at ? \Carbon\Carbon::parse($payment->created_at)->format('M j, Y') : 'N/A' }}</td>
                                                <td class="py-3">
                                                    <button wire:click="flagAsFraud({{ $payment->id }})" class="text-red-600 hover:text-red-800 font-medium text-sm">Review</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(method_exists($suspicious, 'links'))
                            <div class="mt-6">
                                {{ $suspicious->links() }}
                            </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">All Clear!</h3>
                                <p class="text-gray-500">No suspicious transactions detected. Your platform is secure.</p>
                            </div>
                        @endif
                    </div>
                @endif
                
                <!-- Disputes Tab -->
                @if($selectedMetric === 'disputes')
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Payment Disputes</h3>
                                <p class="text-sm text-gray-500">Manage and resolve booking disputes</p>
                            </div>
                        </div>
                        
                        @if(is_object($disputes) && method_exists($disputes, 'total') && $disputes->total() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <th class="pb-3">Booking ID</th>
                                            <th class="pb-3">Guest</th>
                                            <th class="pb-3">Property</th>
                                            <th class="pb-3">Amount</th>
                                            <th class="pb-3">Reason</th>
                                            <th class="pb-3">Date</th>
                                            <th class="pb-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($disputes as $booking)
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-3 text-sm font-medium text-gray-900">#{{ $booking->id }}</td>
                                                <td class="py-3 text-sm text-gray-600">{{ $booking->user->name ?? 'N/A' }}</td>
                                                <td class="py-3 text-sm text-gray-600">{{ $booking->property->title ?? 'N/A' }}</td>
                                                <td class="py-3 text-sm font-bold text-gray-900">${{ number_format($booking->total_amount ?? $booking->total_price ?? 0, 2) }}</td>
                                                <td class="py-3 text-sm text-gray-600">{{ $booking->dispute_reason ?? 'Not specified' }}</td>
                                                <td class="py-3 text-sm text-gray-500">{{ $booking->disputed_at ? \Carbon\Carbon::parse($booking->disputed_at)->format('M j, Y') : 'N/A' }}</td>
                                                <td class="py-3">
                                                    <button wire:click="resolveDispute({{ $booking->id }}, 'refund_guest')" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm font-medium hover:bg-blue-600 transition mr-2">Refund</button>
                                                    <button class="text-gray-500 hover:text-gray-700 text-sm">Details</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(method_exists($disputes, 'links'))
                            <div class="mt-6">
                                {{ $disputes->links() }}
                            </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Disputes</h3>
                                <p class="text-gray-500">There are no active disputes to resolve.</p>
                            </div>
                        @endif
                    </div>
                @endif
                
                <!-- Payouts Tab -->
                @if($selectedMetric === 'payouts')
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Host Payouts</h3>
                                <p class="text-sm text-gray-500">Manage and approve host payment payouts</p>
                            </div>
                        </div>
                        
                        @if(isset($payouts) && !$payouts->isEmpty())
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <th class="pb-3">Host</th>
                                            <th class="pb-3">Email</th>
                                            <th class="pb-3">Pending Bookings</th>
                                            <th class="pb-3">Pending Amount</th>
                                            <th class="pb-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($payouts as $host)
                                            @php
                                                $pendingAmount = \App\Models\Booking::where('host_id', $host->id)->where('payout_status', 'pending')->sum('total_price') ?? 0;
                                            @endphp
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-3">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-rose-500 rounded-full flex items-center justify-center">
                                                            <span class="text-white text-xs font-medium">{{ substr($host->name ?? 'H', 0, 1) }}</span>
                                                        </div>
                                                        <span class="font-medium text-gray-900">{{ $host->name ?? 'Host' }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 text-sm text-gray-600">{{ $host->email ?? 'N/A' }}</td>
                                                <td class="py-3 text-sm text-gray-900">{{ $host->pending_payouts_count ?? 0 }}</td>
                                                <td class="py-3 text-sm font-bold text-gray-900">${{ number_format($pendingAmount, 2) }}</td>
                                                <td class="py-3">
                                                    <button wire:click="approvePayout({{ $host->id }})" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-600 transition">Approve Payout</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Pending Payouts</h3>
                                <p class="text-gray-500">All host payouts have been processed.</p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Activity Log Tab -->
                @if($selectedMetric === 'activity')
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                                <p class="text-sm text-gray-500">Latest platform activities and events</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            @php
                                $activities = \App\Models\Notification::with('user')->latest()->take(20)->get();
                            @endphp
                            @forelse($activities as $activity)
                                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">{{ $activity->title ?? 'Activity' }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $activity->message ?? '' }}</p>
                                        <p class="text-xs text-gray-400 mt-2">{{ $activity->created_at ? \Carbon\Carbon::parse($activity->created_at)->diffForHumans() : '' }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Activity Yet</h3>
                                    <p class="text-gray-500">Platform activities will appear here.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif

                <!-- Users Tab -->
                @if($selectedMetric === 'users')
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">User Management</h3>
                                <p class="text-sm text-gray-500">Manage all platform users</p>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <th class="pb-3">User</th>
                                        <th class="pb-3">Email</th>
                                        <th class="pb-3">Role</th>
                                        <th class="pb-3">Status</th>
                                        <th class="pb-3">Joined</th>
                                        <th class="pb-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($allUsers as $user)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-rose-500 rounded-full flex items-center justify-center">
                                                        <span class="text-white text-xs font-medium">{{ substr($user->name ?? 'U', 0, 1) }}</span>
                                                    </div>
                                                    <span class="font-medium text-gray-900">{{ $user->name ?? 'User' }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 text-sm text-gray-600">{{ $user->email ?? 'N/A' }}</td>
                                            <td class="py-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : ($user->is_host ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ $user->role === 'admin' ? 'Admin' : ($user->is_host ? 'Host' : 'Guest') }}
                                                </span>
                                            </td>
                                            <td class="py-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $user->is_verified ? 'Verified' : 'Pending' }}
                                                </span>
                                            </td>
                                            <td class="py-3 text-sm text-gray-500">{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('M j, Y') : 'N/A' }}</td>
                                            <td class="py-3">
                                                <button wire:click="viewUser({{ $user->id }})" class="text-blue-600 hover:text-blue-800 font-medium text-sm mr-3">View</button>
                                                @if($user->role !== 'admin')
                                                    <button wire:click="toggleUserStatus({{ $user->id }})" class="text-red-600 hover:text-red-800 font-medium text-sm">Suspend</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-8 text-center text-gray-500">No users found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($allUsers && is_object($allUsers) && method_exists($allUsers, 'links') && $allUsers->count() > 0)
                        <div class="mt-6">
                            {{ $allUsers->links() }}
                        </div>
                        @endif
                    </div>
                @endif

                        <!-- Properties Tab -->
                        @if($selectedMetric === 'properties')
                            <div>
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Property Management</h3>
                                        <p class="text-sm text-gray-500">Review and manage all listings</p>
                                    </div>
                                </div>
                                
                                <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <th class="pb-3">Property</th>
                                        <th class="pb-3">Host</th>
                                        <th class="pb-3">Location</th>
                                        <th class="pb-3">Price</th>
                                        <th class="pb-3">Status</th>
                                        <th class="pb-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($allProperties as $property)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                                    </div>
                                                    <span class="font-medium text-gray-900">{{ $property->title ?? 'Property' }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 text-sm text-gray-600">{{ $property->host->name ?? 'N/A' }}</td>
                                            <td class="py-3 text-sm text-gray-600">{{ $property->location ?? 'N/A' }}</td>
                                            <td class="py-3 text-sm font-medium text-gray-900">${{ number_format($property->price ?? 0, 2) }}</td>
                                            <td class="py-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $property->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $property->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="py-3">
                                                <button wire:click="togglePropertyStatus({{ $property->id }})" class="text-blue-600 hover:text-blue-800 font-medium text-sm mr-3">
                                                    {{ $property->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                                <button class="text-gray-500 hover:text-gray-700 text-sm">View</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-8 text-center text-gray-500">No properties found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $allProperties->links() }}
                        </div>
                    </div>
                @endif

                <!-- Bookings Tab -->
                @if($selectedMetric === 'bookings')
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Booking Management</h3>
                                <p class="text-sm text-gray-500">View and manage all bookings</p>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <th class="pb-3">Booking ID</th>
                                        <th class="pb-3">Guest</th>
                                        <th class="pb-3">Property</th>
                                        <th class="pb-3">Dates</th>
                                        <th class="pb-3">Amount</th>
                                        <th class="pb-3">Status</th>
                                        <th class="pb-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($allBookings as $booking)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3 text-sm font-medium text-gray-900">#{{ $booking->id }}</td>
                                            <td class="py-3 text-sm text-gray-600">{{ $booking->user->name ?? 'N/A' }}</td>
                                            <td class="py-3 text-sm text-gray-600">{{ $booking->property->title ?? 'N/A' }}</td>
                                            <td class="py-3 text-sm text-gray-600">
                                                {{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('M j') : 'N/A' }} - {{ $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('M j, Y') : 'N/A' }}
                                            </td>
                                            <td class="py-3 text-sm font-medium text-gray-900">${{ number_format($booking->total_amount ?? $booking->total_price ?? 0, 2) }}</td>
                                            <td class="py-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td class="py-3">
                                                <button wire:click="viewBooking({{ $booking->id }})" class="text-blue-600 hover:text-blue-800 font-medium text-sm">View</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-8 text-center text-gray-500">No bookings found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $allBookings->links() }}
                        </div>
                    </div>
                @endif

                <!-- Settings Tab -->
                @if($selectedMetric === 'settings')
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Platform Settings</h3>
                                <p class="text-sm text-gray-500">Configure platform settings</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- General Settings -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h4 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    General Settings
                                </h4>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Maintenance Mode</span>
                                        <button class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                                            <span class="sr-only">Enable maintenance mode</span>
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-1"></span>
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">User Registration</span>
                                        <button class="relative inline-flex h-6 w-11 items-center rounded-full bg-green-500 transition-colors focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                                            <span class="sr-only">Enable registration</span>
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-6"></span>
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Email Verification</span>
                                        <button class="relative inline-flex h-6 w-11 items-center rounded-full bg-green-500 transition-colors focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                                            <span class="sr-only">Enable email verification</span>
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-6"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Commission Settings -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h4 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Commission Settings
                                </h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm text-gray-600 block mb-1">Platform Commission (%)</label>
                                        <input type="number" value="15" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-600 block mb-1">Host Payout Frequency</label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                            <option>Weekly</option>
                                            <option>Bi-weekly</option>
                                            <option>Monthly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Notification Settings -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h4 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                    Notifications
                                </h4>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Email Notifications</span>
                                        <button class="relative inline-flex h-6 w-11 items-center rounded-full bg-green-500 transition-colors">
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-6"></span>
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">SMS Notifications</span>
                                        <button class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-200 transition-colors">
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-1"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Security Settings -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h4 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    Security
                                </h4>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Two-Factor Auth</span>
                                        <button class="relative inline-flex h-6 w-11 items-center rounded-full bg-green-500 transition-colors">
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-6"></span>
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Fraud Detection</span>
                                        <button class="relative inline-flex h-6 w-11 items-center rounded-full bg-green-500 transition-colors">
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-6"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button class="bg-pink-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-pink-600 transition">
                                Save Settings
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
