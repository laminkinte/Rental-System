<?php

namespace App\Livewire\Messages;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    
    public $conversations = [];
    public $selectedConversation = null;
    public $showNewMessageModal = false;
    public $searchUser = '';
    public $userResults = [];

    public function mount()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        // Get all users the current user has messaged with
        $userId = Auth::id();
        
        $sentMessages = Message::where('sender_id', $userId)
            ->select('receiver_id')
            ->distinct()
            ->pluck('receiver_id');

        $receivedMessages = Message::where('receiver_id', $userId)
            ->select('sender_id')
            ->distinct()
            ->pluck('sender_id');

        $contactIds = $sentMessages->merge($receivedMessages)->unique();

        if ($contactIds->isNotEmpty()) {
            $this->conversations = User::whereIn('id', $contactIds)->get();
        } else {
            $this->conversations = collect([]);
        }
    }

    public function searchUsers()
    {
        if (strlen($this->searchUser) >= 2) {
            $this->userResults = User::where('name', 'like', '%' . $this->searchUser . '%')
                ->orWhere('email', 'like', '%' . $this->searchUser . '%')
                ->where('id', '!=', Auth::id())
                ->limit(10)
                ->get();
        } else {
            $this->userResults = [];
        }
    }

    public function startConversation($userId)
    {
        return redirect()->route('messages.show', $userId);
    }

    public function render()
    {
        return view('livewire.messages.index');
    }
}
