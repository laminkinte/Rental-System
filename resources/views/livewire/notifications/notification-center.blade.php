<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Notifications</h1>
        <p class="text-gray-500">Stay updated on your bookings and messages</p>
        
        <!-- Filter Tabs - Airbnb Style -->
        <div class="flex flex-wrap gap-2 mt-6">
            <button wire:click="updateFilter('all')" 
                class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                {{ $filterType === 'all' 
                    ? 'bg-gray-900 text-white' 
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                All
            </button>
            <button wire:click="updateFilter('unread')" 
                class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                {{ $filterType === 'unread' 
                    ? 'bg-gray-900 text-white' 
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Unread ({{ $unreadCount }})
            </button>
            <button wire:click="updateFilter('booking')" 
                class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                {{ $filterType === 'booking' 
                    ? 'bg-gray-900 text-white' 
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Bookings
            </button>
            <button wire:click="updateFilter('message')" 
                class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                {{ $filterType === 'message' 
                    ? 'bg-gray-900 text-white' 
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Messages
            </button>
            <button wire:click="updateFilter('review')" 
                class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                {{ $filterType === 'review' 
                    ? 'bg-gray-900 text-white' 
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Reviews
            </button>
            <button wire:click="updateFilter('payment')" 
                class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                {{ $filterType === 'payment' 
                    ? 'bg-gray-900 text-white' 
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Payments
            </button>
        </div>
    </div>

    <!-- Search & Action Buttons -->
    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="flex-1 relative">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" wire:model.live="searchTerm" placeholder="Search notifications..." 
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:border-gray-900 focus:ring-1 focus:ring-gray-900 transition-colors">
        </div>
        <div class="flex gap-2">
            <button wire:click="markAllAsRead" class="px-4 py-2 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition-colors">
                Mark All Read
            </button>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="space-y-3">
        @forelse($notifications as $notification)
            <div class="bg-white border rounded-2xl p-5 hover:shadow-md transition-shadow
                {{ !$notification->is_read ? 'border-l-4 border-l-[#FF385C]' : 'border-gray-100' }}">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $notification->type }}</span>
                            @if(!$notification->is_read)
                                <span class="px-2 py-0.5 bg-[#FF385C] text-white text-xs font-medium rounded-full">New</span>
                            @endif
                            <span class="text-xs text-gray-400 ml-auto">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $notification->title }}</h3>
                        <p class="text-gray-600">{{ $notification->message }}</p>
                        
                        @if($notification->data && is_array($notification->data))
                            <div class="mt-3 p-3 bg-gray-50 rounded-xl text-sm text-gray-600">
                                @foreach($notification->data as $key => $value)
                                    <p><span class="font-medium">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span> {{ is_array($value) ? json_encode($value) : $value }}</p>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex items-center gap-3 mt-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $notification->channel }}
                            </span>
                            @if($notification->is_read && $notification->read_at)
                                <span>·</span>
                                <span>Read {{ $notification->read_at->diffForHumans() }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        @if(!$notification->is_read)
                            <button wire:click="markAsRead({{ $notification->id }})" 
                                class="px-4 py-2 text-sm font-medium bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                Mark Read
                            </button>
                        @endif
                        <button wire:click="deleteNotification({{ $notification->id }})" 
                            class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-red-600 transition-colors">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white rounded-2xl border border-gray-100">
                <div class="text-6xl mb-4">🔔</div>
                <p class="text-gray-500 text-lg">No notifications yet</p>
                <p class="text-gray-400 text-sm mt-1">We'll notify you when something happens</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifications->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
