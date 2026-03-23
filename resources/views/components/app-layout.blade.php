<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'JubbaStay') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Tailwind CSS via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Livewire Styles -->
        @livewireStyles

        <style>
            body {
                font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }
            
            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }
            ::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #a1a1a1;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800">
        <div class="min-h-screen flex flex-col">
            <!-- Navigation -->
            <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-[#FF385C] to-[#FF5A5F] rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                </div>
                                <span class="text-2xl font-bold text-[#FF385C]">JubbaStay</span>
                            </a>
                        </div>

                        <!-- Search Bar -->
                        <div class="hidden md:flex flex-1 justify-center px-8">
                            <a href="{{ route('properties.search') }}" class="flex items-center bg-white border border-gray-300 rounded-full shadow-sm hover:shadow-md transition-shadow px-6 py-2.5">
                                <span class="text-sm font-medium text-gray-800 border-r border-gray-300 pr-4">Where do you want to stay?</span>
                                <span class="text-sm font-medium text-gray-500 px-4">Any week</span>
                                <span class="text-sm font-medium text-gray-500 border-l border-gray-300 pl-4">Add guests</span>
                                <div class="ml-4 bg-[#FF385C] text-white p-2 rounded-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </a>
                        </div>

                        <!-- Right Menu -->
                        <div class="flex items-center gap-4" x-data="{ open: false }">
                            <a href="{{ route('properties.search') }}" class="hidden md:flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Explore
                            </a>
                            
                            @auth
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">Dashboard</a>
                                @elseif(Auth::user()->isHost())
                                    <a href="{{ route('host.dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">Dashboard</a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">Dashboard</a>
                                @endif
                                
                                <!-- User Menu -->
                                <div class="relative">
                                    <button @click="open = !open" class="flex items-center gap-2 border border-gray-300 rounded-full px-3 py-1.5 hover:shadow-md transition-shadow">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                        </svg>
                                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                    </button>
                                    
                                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2">
                                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                                        <a href="{{ route('wallet.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Wallet</a>
                                        <a href="{{ route('messages.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Messages</a>
                                        <hr class="my-2">
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Log out</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">Log in</a>
                                <a href="{{ route('register') }}" class="bg-[#FF385C] hover:bg-[#E2324A] text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">Sign up</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500">© 2026 JubbaStay. All rights reserved.</span>
                        </div>
                        <div class="flex items-center gap-6">
                            <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Terms</a>
                            <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Sitemap</a>
                            <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Privacy</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        
        <!-- Notification Toast -->
        <div x-data="{ show: false, message: '' }" 
             @notify.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000)"
             x-show="show"
             x-transition
             class="fixed bottom-4 right-4 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-lg z-50">
            <span x-text="message"></span>
        </div>
        
        @livewireScripts
    </body>
</html>
