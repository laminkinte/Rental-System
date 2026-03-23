<!-- Group Booking Creator View -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Create Group Booking</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
    <!-- Progress Steps / Main Content -->
    <div class="lg:col-span-2">
    <div class="flex justify-between mb-8 border-b pb-4">
        @for ($step = 1; $step <= 4; $step++)
            <div class="flex-1">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold {{ $step <= $currentStep ? 'bg-black text-white' : 'bg-gray-200 text-gray-600' }}">
                        {{ $step }}
                    </div>
                    @if ($step < 4)
                        <div class="flex-1 h-0.5 {{ $step < $currentStep ? 'bg-black' : 'bg-gray-200' }} mx-2"></div>
                    @endif
                </div>
                <p class="text-xs mt-2 text-center">
                    @switch($step)
                        @case(1) Basics @break
                        @case(2) Members @break
                        @case(3) Properties @break
                        @case(4) Payment @break
                    @endswitch
                </p>
            </div>
        @endfor
    </div>

    <!-- Step 1: Basics -->
    @if ($currentStep == 1)
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h2 class="text-2xl font-bold mb-4">Booking Details</h2>
            
            <div>
                <label class="block text-sm font-medium mb-2">Booking Title</label>
                <input type="text" wire:model="title" placeholder="e.g., Summer Trip to Gambia" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Description</label>
                <textarea wire:model="description" placeholder="Tell us about your group trip..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg h-20 focus:ring-2 focus:ring-blue-500"></textarea>
                @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Number of Guests</label>
                <input type="number" wire:model="guestCount" min="2" max="50" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('guestCount') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-4 pt-4">
                <button wire:click="nextStep" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Next
                </button>
            </div>
        </div>
    @endif

    <!-- Step 2: Members -->
    @if ($currentStep == 2)
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h2 class="text-2xl font-bold mb-4">Add Group Members</h2>
            
            <div class="flex gap-2 mb-4">
                <input type="email" wire:model="memberEmail" placeholder="Email address" 
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
                <button wire:click="addMember" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    Add Member
                </button>
            </div>

            @error('memberEmail') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <!-- Members List -->
            <div class="space-y-2">
                @forelse($members as $index => $member)
                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded">
                        <span>{{ $member['email'] }}</span>
                        <button wire:click="removeMember('{{ $member['email'] }}')" 
                            class="text-red-600 hover:text-red-700">Remove</button>
                    </div>
                @empty
                    <p class="text-gray-500">No members added yet</p>
                @endforelse
            </div>

            <div class="flex gap-4 pt-4">
                <button wire:click="prevStep" class="flex-1 bg-gray-400 text-white py-2 rounded-lg hover:bg-gray-500">
                    Back
                </button>
                <button wire:click="nextStep" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Next
                </button>
            </div>
        </div>
    @endif

    <!-- Step 3: Properties & Dates -->
    @if ($currentStep == 3)
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h2 class="text-2xl font-bold mb-4">Select Properties & Dates</h2>
            
            <div>
                <label class="block text-sm font-medium mb-2">Booking Type</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" wire:model="propertySelection" value="single" 
                            class="mr-2"> Single Property
                    </label>
                    <label class="flex items-center">
                        <input type="radio" wire:model="propertySelection" value="multi" 
                            class="mr-2"> Multiple Properties
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Select Properties</label>
                <div class="space-y-2 max-h-60 overflow-y-auto border border-gray-300 rounded-lg p-3">
                    @foreach($properties as $property)
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="selectedProperties" value="{{ $property->id }}" 
                                class="mr-2">
                            <span>{{ $property->title }} - ${{ number_format($property->base_price, 2) }}/night</span>
                        </label>
                    @endforeach
                </div>
                @error('selectedProperties') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Check-in Date</label>
                    <input type="date" wire:model="checkIn" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    @error('checkIn') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Check-out Date</label>
                    <input type="date" wire:model="checkOut" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    @error('checkOut') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="bg-blue-50 p-4 rounded">
                <p class="text-sm"><strong>Estimated Total:</strong> ${{ number_format($totalAmount, 2) }}</p>
            </div>

            <div class="flex gap-4 pt-4">
                <button wire:click="prevStep" class="flex-1 bg-gray-400 text-white py-2 rounded-lg hover:bg-gray-500">
                    Back
                </button>
                <button wire:click="nextStep" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Next
                </button>
            </div>
        </div>
    @endif

    <!-- Step 4: Payment Split -->
    @if ($currentStep == 4)
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h2 class="text-2xl font-bold mb-4">Payment Split</h2>
            
            <div>
                <label class="block text-sm font-medium mb-2">How to split payment?</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" wire:model="splitType" value="equal" class="mr-2"> 
                        Equal Split (${@php echo round($totalAmount / (count($members) + 1), 2) @endphp} each)
                    </label>
                    <label class="flex items-center">
                        <input type="radio" wire:model="splitType" value="custom" class="mr-2">
                        Custom Split
                    </label>
                    <label class="flex items-center">
                        <input type="radio" wire:model="splitType" value="organizer_pays" class="mr-2">
                        Organizer Pays All
                    </label>
                </div>
            </div>

            <!-- Payment Breakdown -->
            <div class="bg-gray-50 p-4 rounded space-y-2">
                <p class="font-bold">Payment Breakdown:</p>
                
                <div class="flex justify-between">
                    <span>Organizer (You)</span>
                    <span>${{ number_format($splitPayment['organizer'] ?? 0, 2) }}</span>
                </div>

                @foreach($members as $member)
                    <div class="flex justify-between">
                        <span>{{ $member['email'] }}</span>
                        <span>${{ number_format($splitPayment[$member['email']] ?? 0, 2) }}</span>
                    </div>
                @endforeach

                <div class="border-t pt-2 flex justify-between font-bold">
                    <span>Total</span>
                    <span>${{ number_format($totalAmount, 2) }}</span>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <button wire:click="prevStep" class="flex-1 bg-gray-400 text-white py-2 rounded-lg hover:bg-gray-500">
                    Back
                </button>
                <button wire:click="saveGroupBooking" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                    Create Booking
                </button>
            </div>
        </div>
    @endif
</div>
