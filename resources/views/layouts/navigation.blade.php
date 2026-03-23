<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">
                        🏖️ JubbaStay Gambia
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('home') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>
                    <a href="{{ route('properties.search') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Search</a>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('properties.index') }}" class="text-gray-700 hover:text-gray-900 text-sm">My Properties</a>
                    <a href="{{ route('properties.create') }}" class="text-gray-700 hover:text-gray-900 text-sm">List Property</a>
                    <a href="{{ route('profiles.edit') }}" class="text-gray-700 hover:text-gray-900 text-sm">Profile</a>

                    <!-- Admin Link (show only for admin users) -->
                    @if(Auth::user()->email === 'admin@jubbastay.com' || Auth::user()->id === 1) <!-- Temporary admin check -->
                        <a href="{{ route('admin.dashboard') }}" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Admin</a>
                    @endif

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-medium text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('profiles.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Profile</a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 text-sm">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Sign Up</a>
                @endauth
            </div>
        </div>
    </div>
</nav>