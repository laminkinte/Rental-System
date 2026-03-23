<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 bg-gradient-to-br from-[#FF385C] to-[#FF5A5F] rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Create your account</h2>
            <p class="mt-2 text-sm text-gray-600">Join thousands of travelers worldwide</p>
        </div>

        <!-- Register Form -->
        <form wire:submit.prevent="register" class="mt-8 space-y-5 bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
            
            <!-- Profile Type Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">I want to join as:</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model="profile_type" value="guest" class="peer sr-only" checked>
                        <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-[#FF385C] peer-checked:bg-[#FF385C]/5 transition-all duration-200">
                            <div class="flex flex-col items-center text-center">
                                <svg class="w-8 h-8 mb-2 text-gray-400 peer-checked:text-[#FF385C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="font-medium text-gray-700">Guest</span>
                                <span class="text-xs text-gray-500 mt-1">Book stays</span>
                            </div>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model="profile_type" value="host" class="peer sr-only">
                        <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-[#FF385C] peer-checked:bg-[#FF385C]/5 transition-all duration-200">
                            <div class="flex flex-col items-center text-center">
                                <svg class="w-8 h-8 mb-2 text-gray-400 peer-checked:text-[#FF385C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span class="font-medium text-gray-700">Host</span>
                                <span class="text-xs text-gray-500 mt-1">List properties</span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Full Name
                    </span>
                </label>
                <input id="name" 
                       type="text" 
                       wire:model="name" 
                       required 
                       autofocus 
                       autocomplete="name" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#FF385C] focus:ring-2 focus:ring-[#FF385C]/20 transition-all duration-200 placeholder-gray-400"
                       placeholder="Enter your full name">
                @error('name') 
                    <span class="text-red-500 text-sm mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </span> 
                @enderror
            </div>

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Username
                    </span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">@</span>
                    <input id="username" 
                           type="text" 
                           wire:model="username" 
                           required 
                           autocomplete="username" 
                           class="w-full pl-8 pr-4 py-3 rounded-xl border border-gray-300 focus:border-[#FF385C] focus:ring-2 focus:ring-[#FF385C]/20 transition-all duration-200 placeholder-gray-400"
                           placeholder="Choose a username">
                </div>
                @error('username') 
                    <span class="text-red-500 text-sm mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </span> 
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Email Address
                    </span>
                </label>
                <input id="email" 
                       type="email" 
                       wire:model="email" 
                       required 
                       autocomplete="email" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#FF385C] focus:ring-2 focus:ring-[#FF385C]/20 transition-all duration-200 placeholder-gray-400"
                       placeholder="Enter your email">
                @error('email') 
                    <span class="text-red-500 text-sm mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </span> 
                @enderror
            </div>

            <!-- Phone Number -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Phone Number (Optional)
                    </span>
                </label>
                <input id="phone" 
                       type="tel" 
                       wire:model="phone" 
                       autocomplete="tel" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#FF385C] focus:ring-2 focus:ring-[#FF385C]/20 transition-all duration-200 placeholder-gray-400"
                       placeholder="+1 234 567 8900">
                @error('phone') 
                    <span class="text-red-500 text-sm mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </span> 
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Password
                    </span>
                </label>
                <div class="relative">
                    <input id="password" 
                           type="password" 
                           wire:model="password" 
                           required 
                           autocomplete="new-password" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#FF385C] focus:ring-2 focus:ring-[#FF385C]/20 transition-all duration-200 placeholder-gray-400 pr-12"
                           placeholder="Create a strong password">
                    <button type="button" onclick="toggleRegPassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg id="reg-eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <!-- Password Strength Indicator -->
                <div class="mt-2">
                    <div class="flex gap-1">
                        <div class="h-1 flex-1 rounded-full bg-gray-200" id="strength-1"></div>
                        <div class="h-1 flex-1 rounded-full bg-gray-200" id="strength-2"></div>
                        <div class="h-1 flex-1 rounded-full bg-gray-200" id="strength-3"></div>
                        <div class="h-1 flex-1 rounded-full bg-gray-200" id="strength-4"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Use 8+ characters with a mix of letters, numbers & symbols</p>
                </div>
                @error('password') 
                    <span class="text-red-500 text-sm mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </span> 
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Confirm Password
                    </span>
                </label>
                <input id="password_confirmation" 
                       type="password" 
                       wire:model="password_confirmation" 
                       required 
                       autocomplete="new-password" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#FF385C] focus:ring-2 focus:ring-[#FF385C]/20 transition-all duration-200 placeholder-gray-400"
                       placeholder="Confirm your password">
            </div>

            <!-- Terms Checkbox -->
            <div class="flex items-start">
                <input id="terms" 
                       type="checkbox" 
                       required
                       class="h-4 w-4 mt-1 text-[#FF385C] focus:ring-[#FF385C] border-gray-300 rounded cursor-pointer">
                <label for="terms" class="ml-2 block text-sm text-gray-600 cursor-pointer">
                    I agree to the 
                    <a href="#" class="text-[#FF385C] hover:underline">Terms of Service</a>, 
                    <a href="#" class="text-[#FF385C] hover:underline">Privacy Policy</a>, and 
                    <a href="#" class="text-[#FF385C] hover:underline">Cookie Policy</a>
                </label>
            </div>

            <!-- Marketing Opt-in -->
            <div class="flex items-center">
                <input id="marketing" 
                       type="checkbox" 
                       wire:model="marketing_consent"
                       class="h-4 w-4 text-[#FF385C] focus:ring-[#FF385C] border-gray-300 rounded cursor-pointer">
                <label for="marketing" class="ml-2 block text-sm text-gray-600 cursor-pointer">
                    Send me news, offers, and travel inspiration
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full flex justify-center items-center py-3.5 px-4 rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-[#FF385C] to-[#FF5A5F] hover:from-[#E2324A] hover:to-[#FF385C] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF385C] transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                <span wire:loading.remove wire:target="register">Create Account</span>
                <span wire:loading wire:target="register" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Creating account...
                </span>
            </button>
        </form>

        <!-- Divider -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="px-4 bg-gradient-to-r from-transparent via-gray-400 to-transparent text-sm text-gray-500 bg-gray-100">or sign up with</span>
            </div>
        </div>

        <!-- Social Login -->
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('auth.magic_link') }}" class="flex justify-center items-center py-3 px-4 border border-gray-200 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                <svg class="w-5 h-5 mr-2 text-[#FF385C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Magic Link
            </a>
            <a href="{{ route('auth.otp_login') }}" class="flex justify-center items-center py-3 px-4 border border-gray-200 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                <svg class="w-5 h-5 mr-2 text-[#FF385C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                OTP Code
            </a>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-4">
            <p class="text-sm text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-semibold text-[#FF385C] hover:text-[#E2324A] transition-colors">
                    Sign in
                </a>
            </p>
        </div>

        <!-- Security Notice -->
        <div class="flex items-center justify-center text-xs text-gray-400 mt-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            Your information is protected with encryption
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleRegPassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('reg-eye-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        }
    }

    // Password strength indicator
    document.getElementById('password').addEventListener('input', function(e) {
        const password = e.target.value;
        const strength1 = document.getElementById('strength-1');
        const strength2 = document.getElementById('strength-2');
        const strength3 = document.getElementById('strength-3');
        const strength4 = document.getElementById('strength-4');
        
        let strength = 0;
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password) || /[^a-zA-Z0-9]/.test(password)) strength++;
        
        strength1.className = 'h-1 flex-1 rounded-full ' + (strength >= 1 ? 'bg-red-500' : 'bg-gray-200');
        strength2.className = 'h-1 flex-1 rounded-full ' + (strength >= 2 ? 'bg-orange-500' : 'bg-gray-200');
        strength3.className = 'h-1 flex-1 rounded-full ' + (strength >= 3 ? 'bg-yellow-500' : 'bg-gray-200');
        strength4.className = 'h-1 flex-1 rounded-full ' + (strength >= 4 ? 'bg-green-500' : 'bg-gray-200');
    });
</script>
@endpush
