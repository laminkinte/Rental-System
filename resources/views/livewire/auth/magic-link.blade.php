<div class="min-h-screen flex items-center justify-center bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto w-12 h-12 bg-gradient-to-br from-[#FF385C] to-[#FF5A5F] rounded-full flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Magic Login</h2>
            <p class="mt-2 text-sm text-gray-600">Enter your email and we'll send you an instant login link</p>
        </div>

        <!-- Success Message -->
        @if($sent)
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ $message }}</p>
                    </div>
                </div>
            </div>

            <!-- Development: Show the magic link -->
            @if(session('magic_link'))
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm font-medium text-yellow-800 mb-2">🔧 Development Mode - Magic Link:</p>
                    <a href="{{ session('magic_link') }}" class="text-sm text-blue-600 hover:text-blue-800 break-all">{{ session('magic_link') }}</a>
                    <p class="text-xs text-yellow-600 mt-2">This link expires in 15 minutes.</p>
                </div>
            @endif

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-[#FF385C] hover:text-[#E2324A] font-medium">
                    ← Back to login
                </a>
            </div>
        @else
            <!-- Magic Link Form -->
            <form wire:submit.prevent="sendLink" class="mt-8 space-y-6 bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input wire:model="email" 
                           type="email" 
                           id="email" 
                           required
                           autofocus
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 transition-colors placeholder-gray-400"
                           placeholder="Enter your email address">
                    @error('email') 
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-[#FF385C] hover:bg-[#E2324A] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF385C] transition-all duration-200">
                    Send Magic Link
                </button>
            </form>

            <div class="text-center">
                <p class="text-sm text-gray-500">Tip: Check your spam folder if you don't see the email.</p>
            </div>
        @endif

        <!-- Back to Login -->
        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to regular login
            </a>
        </div>
    </div>
</div>
