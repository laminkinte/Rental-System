<div class="space-y-4">
    <div>
        <h2 class="text-2xl font-bold">Login with SMS code</h2>
        <p class="text-sm text-gray-600">Enter your phone number to receive a one-time code.</p>
    </div>

    @if($step === 1)
        <form wire:submit.prevent="sendOtp" class="space-y-4">
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input wire:model="phone" type="text" id="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="+2201234567">
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Send code</button>
        </form>
    @else
        <div class="p-4 bg-green-50 border border-green-200 rounded">
            <p class="text-sm font-medium text-green-800">{{ $message }}</p>
        </div>

        <form wire:submit.prevent="verifyOtp" class="space-y-4">
            <div>
                <label for="otp" class="block text-sm font-medium text-gray-700">Enter code</label>
                <input wire:model="otp" type="text" id="otp" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="123456">
                @error('otp') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Verify &amp; Login</button>
        </form>
    @endif
</div>
