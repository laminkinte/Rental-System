<div>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Messages</h1>
                    <p class="text-gray-600 mt-2">Your conversations with hosts and guests</p>
                </div>
                <button wire:click="$toggle('showNewMessageModal')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Message
                </button>
            </div>

            <!-- Search Users Modal -->
            @if($showNewMessageModal)
                <div class="bg-white rounded-lg shadow mb-6 p-6">
                    <h3 class="text-lg font-semibold mb-4">Start a New Conversation</h3>
                    <div class="mb-4">
                        <input 
                            type="text" 
                            wire:model="searchUser" 
                            wire:input="searchUsers()"
                            placeholder="Search by name or email..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                    </div>
                    @if(count($userResults) > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($userResults as $user)
                                <button wire:click="startConversation({{ $user->id }})" class="w-full text-left px-4 py-3 hover:bg-gray-50 transition flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @elseif(strlen($searchUser) >= 2)
                        <p class="text-gray-500 text-center py-4">No users found</p>
                    @endif
                </div>
            @endif

            <div class="bg-white rounded-lg shadow">
                @if($conversations->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($conversations as $user)
                            <a href="{{ route('messages.show', $user->id) }}" class="block px-6 py-4 hover:bg-gray-50 transition">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-lg">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="p-8 text-center">
                        <div class="text-gray-400 mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No messages yet</h3>
                        <p class="text-gray-600 mb-4">Start a conversation by contacting a host about a property</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Browse Properties
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
