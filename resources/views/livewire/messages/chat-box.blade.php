<div>
<div class="bg-white rounded-lg shadow h-96 flex flex-col">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        @if($recipient)
        <div>
            <h3 class="font-semibold text-gray-900">{{ $recipient->name }}</h3>
            <p class="text-xs text-gray-500">{{ $recipient->username ?? $recipient->email }}</p>
        </div>
        @else
        <div>
            <h3 class="font-semibold text-gray-900">Select a conversation</h3>
            <p class="text-xs text-gray-500">Choose a conversation from the list</p>
        </div>
        @endif
    </div>

    <!-- Messages -->
    <div class="flex-1 overflow-y-auto p-6 bg-gray-50">
        @forelse($messages as $message)
            <div class="mb-4 {{ $message['sender_id'] === auth()->id() ? 'text-right' : 'text-left' }}">
                <div class="inline-block max-w-xs {{ $message['sender_id'] === auth()->id() ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-900' }} rounded-lg px-4 py-2">
                    <p class="text-sm">{{ $message['message'] }}</p>
                    <p class="text-xs {{ $message['sender_id'] === auth()->id() ? 'text-blue-100' : 'text-gray-500' }} mt-1">
                        {{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}
                    </p>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-8">
                <p>No messages yet. Start the conversation!</p>
            </div>
        @endforelse
    </div>

    <!-- Message Input -->
    @if($recipient)
    <div class="border-t border-gray-200 p-4">
        <form wire:submit.prevent="sendMessage" class="flex gap-2">
            <input 
                type="text" 
                wire:model="newMessage"
                placeholder="Type a message..." 
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
            <button 
                type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
            >
                Send
            </button>
        </form>
    </div>
    @endif
</div>
</div>
