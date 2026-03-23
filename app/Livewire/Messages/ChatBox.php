<?php

namespace App\Livewire\Messages;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ChatBox extends Component
{
    public $recipientId;
    public $recipient;
    public $messages = [];
    public $newMessage = '';
    public $bookingId;

    protected $listeners = ['messageAdded' => 'loadMessages'];

    public function mount($user, $bookingId = null)
    {
        $this->recipientId = $user instanceof User ? $user->id : (is_numeric($user) ? (int) $user : null);
        $this->recipient = $this->recipientId ? User::find($this->recipientId) : null;
        $this->bookingId = $bookingId ? (int) $bookingId : null;
        
        // Initialize messages as empty array to avoid hydration issues
        $this->messages = [];
        $this->loadMessages();
    }

    /**
     * Handle component hydration - convert any Collection to array
     */
    public function hydrate(): void
    {
        if ($this->messages instanceof Collection) {
            $this->messages = $this->messages->toArray();
        } elseif (!is_array($this->messages)) {
            $this->messages = [];
        }
    }

    public function loadMessages()
    {
        $query = Message::where(function ($q) {
            $q->where('sender_id', Auth::id())
              ->where('receiver_id', $this->recipientId);
        })->orWhere(function ($q) {
            $q->where('sender_id', $this->recipientId)
              ->where('receiver_id', Auth::id());
        });

        if ($this->bookingId) {
            $query->where('booking_id', $this->bookingId);
        }

        $messages = $query->orderBy('created_at', 'asc')->get();

        // Convert to array for Livewire to avoid Collection issues
        $this->messages = $messages->map(function ($msg) {
            return [
                'id' => $msg->id,
                'sender_id' => $msg->sender_id,
                'receiver_id' => $msg->receiver_id,
                'booking_id' => $msg->booking_id,
                'message' => $msg->message,
                'message_type' => $msg->message_type,
                'is_read' => $msg->is_read,
                'read_at' => $msg->read_at?->toIso8601String(),
                'created_at' => $msg->created_at->toIso8601String(),
                'updated_at' => $msg->updated_at->toIso8601String(),
            ];
        })->toArray();

        // Mark all messages as read
        Message::where('receiver_id', Auth::id())
            ->where('sender_id', $this->recipientId)
            ->update(['is_read' => true, 'read_at' => now()]);
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->recipientId,
            'booking_id' => $this->bookingId,
            'message' => $this->newMessage,
            'message_type' => 'general',
        ]);

        $this->newMessage = '';
        $this->loadMessages();
        $this->dispatch('messageSent');
    }

    public function render()
    {
        return view('livewire.messages.chat-box');
    }
}
