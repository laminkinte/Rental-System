<div class="bg-white rounded-2xl border border-gray-200 p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <button wire:click="previousMonth" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <h3 class="font-semibold text-gray-900">{{ $monthName }}</h3>
        <button wire:click="nextMonth" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
    
    <!-- Day Labels -->
    <div class="grid grid-cols-7 gap-1 mb-2">
        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
            <div class="text-center text-xs font-medium text-gray-500 py-2">{{ $day }}</div>
        @endforeach
    </div>
    
    <!-- Calendar Grid -->
    <div class="grid grid-cols-7 gap-1">
        @foreach($weeks as $week)
            @foreach($week as $day)
                @if($day === null)
                    <div class="h-10"></div>
                @else
                    <button 
                        wire:click="selectDate('{{ $day['date'] }}')"
                        @if($day['isPast'] || $day['isBooked'])
                            disabled
                            class="h-10 rounded-lg text-sm font-medium relative
                            {{ $day['isPast'] ? 'text-gray-300 cursor-not-allowed' : '' }}
                            {{ $day['isBooked'] ? 'text-gray-400 bg-gray-100 cursor-not-allowed' : '' }}"
                        @else
                            class="h-10 rounded-lg text-sm font-medium relative transition-all
                            {{ $day['isToday'] ? 'ring-2 ring-[#FF385C]' : '' }}
                            {{ $day['isCheckIn'] || $day['isCheckOut'] ? 'bg-[#FF385C] text-white' : '' }}
                            {{ $day['isInRange'] ? 'bg-red-50 text-[#FF385C]' : '' }}
                            hover:bg-gray-100"
                        @endif
                    >
                        {{ $day['day'] }}
                        @if($day['isBooked'] && !$day['isPast'])
                            <span class="absolute bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 bg-gray-400 rounded-full"></span>
                        @endif
                    </button>
                @endif
            @endforeach
        @endforeach
    </div>
    
    <!-- Legend -->
    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-gray-100">
        <div class="flex items-center gap-2">
            <span class="w-4 h-4 rounded bg-[#FF385C]"></span>
            <span class="text-xs text-gray-600">Selected</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-4 h-4 rounded bg-red-50 border border-[#FF385C]"></span>
            <span class="text-xs text-gray-600">Range</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-4 h-4 rounded bg-gray-100"></span>
            <span class="text-xs text-gray-600">Unavailable</span>
        </div>
    </div>
    
    <!-- Selected Dates -->
    @if($checkIn || $checkOut)
    <div class="mt-4 p-4 bg-gray-50 rounded-xl">
        <div class="flex items-center justify-between">
            <div class="flex gap-4">
                <div>
                    <p class="text-xs text-gray-500">Check-in</p>
                    <p class="font-medium text-gray-900">{{ $checkIn ? \Carbon\Carbon::parse($checkIn)->format('M d, Y') : '--' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Check-out</p>
                    <p class="font-medium text-gray-900">{{ $checkOut ? \Carbon\Carbon::parse($checkOut)->format('M d, Y') : '--' }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">Nights</p>
                <p class="font-semibold text-lg text-[#FF385C]">{{ $nights }}</p>
            </div>
        </div>
        <button wire:click="clearDates" class="mt-3 text-sm text-gray-500 hover:text-red-500 transition-colors">
            Clear dates
        </button>
    </div>
    @endif
    
    <!-- Selection Hint -->
    @if(!$checkIn)
    <p class="mt-4 text-xs text-gray-500 text-center">
        {{ $selecting === 'checkin' ? 'Select check-in date' : 'Select check-out date' }}
    </p>
    @endif
</div>
