<!-- Verification Manager View -->
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-4xl font-bold mb-8">Trust & Verification</h1>

    <!-- Badges Display -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-2xl font-bold mb-6">Your Badges</h2>
        
        @if(count($badges) > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($badges as $key => $badge)
                    <div class="text-center p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg border-2 border-{{ $badge['color'] }}-200">
                        <p class="text-4xl mb-2">{{ $badge['icon'] }}</p>
                        <p class="font-bold text-sm">{{ $badge['name'] }}</p>
                        <p class="text-xs text-gray-600 mt-2">{{ $badge['description'] }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No badges earned yet. Complete verifications to earn trust badges!</p>
        @endif
    </div>

    <!-- Tab Navigation -->
    <div class="flex border-b mb-6 space-x-6">
        @foreach(['id_verification', 'phone_verification', 'email_verification', 'badges'] as $tab)
            <button wire:click="$set('selectedTab', '{{ $tab }}')" 
                class="pb-3 font-medium border-b-2 transition {{ $selectedTab === $tab ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
                @switch($tab)
                    @case('id_verification') ID Verification @break
                    @case('phone_verification') Phone Verification @break
                    @case('email_verification') Email Verification @break
                    @case('badges') Badges Info @break
                @endswitch
            </button>
        @endforeach
    </div>

    <!-- ID Verification Tab -->
    @if($selectedTab === 'id_verification')
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">ID Verification</h2>
            <p class="text-gray-600 mb-6">Verify your identity to unlock additional features and build trust with the community.</p>
            
            @if($user->id_verification_status === 'approved')
                <div class="bg-green-100 border border-green-300 rounded-lg p-4 mb-6">
                    <p class="text-green-800">✓ Your ID has been verified</p>
                </div>
            @elseif($user->id_verification_status === 'pending')
                <div class="bg-yellow-100 border border-yellow-300 rounded-lg p-4 mb-6">
                    <p class="text-yellow-800">⏳ Your ID verification is pending review</p>
                </div>
            @else
                <form wire:submit="submitIdVerification" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Document Type</label>
                        <select wire:model="idDocumentType" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="passport">Passport</option>
                            <option value="national_id">National ID Card</option>
                            <option value="drivers_license">Driver's License</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Document Front Photo</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:bg-gray-50"
                            @click="$refs.frontPhoto.click()">
                            @if($idDocumentFront)
                                <img src="{{ $idDocumentFront->temporaryUrl() }}" class="max-h-40 mx-auto mb-2">
                            @else
                                <p class="text-gray-500">Click to upload front of document</p>
                            @endif
                        </div>
                        <input type="file" #frontPhoto wire:model="idDocumentFront" accept="image/*" class="hidden">
                        @error('idDocumentFront') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Document Back Photo (Optional)</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:bg-gray-50"
                            @click="$refs.backPhoto.click()">
                            @if($idDocumentBack)
                                <img src="{{ $idDocumentBack->temporaryUrl() }}" class="max-h-40 mx-auto mb-2">
                            @else
                                <p class="text-gray-500">Click to upload back of document</p>
                            @endif
                        </div>
                        <input type="file" #backPhoto wire:model="idDocumentBack" accept="image/*" class="hidden">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-medium">
                        Submit for Verification
                    </button>
                </form>
            @endif
        </div>
    @endif

    <!-- Phone Verification Tab -->
    @if($selectedTab === 'phone_verification')
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Phone Verification</h2>
            <p class="text-gray-600 mb-6">Verify your phone number to improve account security.</p>
            
            @if($user->phone_verified)
                <div class="bg-green-100 border border-green-300 rounded-lg p-4">
                    <p class="text-green-800">✓ Your phone is verified ({{ $user->phone }})</p>
                </div>
            @else
                <div class="space-y-4 max-w-md">
                    <div>
                        <label class="block text-sm font-medium mb-2">Phone Number</label>
                        <input type="tel" wire:model="phone" placeholder="+1 555 0123" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    @if(session()->has('info'))
                        <div class="bg-blue-100 border border-blue-300 rounded-lg p-4 mb-4">
                            <p class="text-blue-800">{{ session('info') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Verification Code</label>
                            <input type="text" wire:model="codeInput" placeholder="000000" maxlength="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center text-2xl tracking-widest">
                            @error('codeInput') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button wire:click="verifyPhoneCode" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                            Verify Code
                        </button>
                    @else
                        <button wire:click="sendPhoneVerification" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                            Send Verification Code
                        </button>
                    @endif
                </div>
            @endif
        </div>
    @endif

    <!-- Email Verification Tab -->
    @if($selectedTab === 'email_verification')
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Email Verification</h2>
            <p class="text-gray-600 mb-6">Manage your email address verification status.</p>
            
            @if($user->email_verified_at)
                <div class="bg-green-100 border border-green-300 rounded-lg p-4">
                    <p class="text-green-800">✓ Your email is verified ({{ $user->email }})</p>
                    <p class="text-sm text-green-700 mt-2">Verified on {{ $user->email_verified_at->format('M d, Y') }}</p>
                </div>
            @else
                <div class="bg-yellow-100 border border-yellow-300 rounded-lg p-4">
                    <p class="text-yellow-800">⏳ Please verify your email address</p>
                    <button class="mt-3 bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 text-sm">
                        Resend Verification Email
                    </button>
                </div>
            @endif
        </div>
    @endif

    <!-- Badges Info Tab -->
    @if($selectedTab === 'badges')
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-6">How to Earn Trust Badges</h2>
            
            <div class="space-y-6">
                <div class="border-l-4 border-blue-600 pl-4 py-2">
                    <h3 class="font-bold mb-2">🎫 Superhost Badge</h3>
                    <p class="text-gray-600 text-sm">Maintain a 4.8+ rating and 90%+ message response rate for 3 consecutive months</p>
                </div>

                <div class="border-l-4 border-purple-600 pl-4 py-2">
                    <h3 class="font-bold mb-2">🏆 Professional Host Badge</h3>
                    <p class="text-gray-600 text-sm">List and manage 5 or more active properties with positive guest reviews</p>
                </div>

                <div class="border-l-4 border-emerald-600 pl-4 py-2">
                    <h3 class="font-bold mb-2">🌱 Eco-Friendly Badge</h3>
                    <p class="text-gray-600 text-sm">Achieve a sustainability score of 80+ through green practices</p>
                </div>

                <div class="border-l-4 border-amber-600 pl-4 py-2">
                    <h3 class="font-bold mb-2">⚡ Highly Responsive Badge</h3>
                    <p class="text-gray-600 text-sm">Maintain 95%+ message response rate for 3 consecutive months</p>
                </div>

                <div class="border-l-4 border-slate-600 pl-4 py-2">
                    <h3 class="font-bold mb-2">🎖️ Veteran Host Badge</h3>
                    <p class="text-gray-600 text-sm">Be a host on JubbaStay for 2+ years with consistent positive activity</p>
                </div>
            </div>
        </div>
    @endif
</div>
