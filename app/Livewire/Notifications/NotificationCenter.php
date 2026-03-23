<?php

namespace App\Livewire\Notifications;

use App\Models\Notification;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class NotificationCenter extends Component
{
    use WithPagination;

    public $filterType = 'all'; // all, unread, booking, message, review, payment, system
    public $searchTerm = '';

    public function updateFilter($type)
    {
        $this->filterType = $type;
        $this->resetPage();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::findOrFail($notificationId);
        
        if ($notification->user_id === Auth::id()) {
            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    public function deleteNotification($notificationId)
    {
        $notification = Notification::findOrFail($notificationId);
        
        if ($notification->user_id === Auth::id()) {
            $notification->delete();
        }
    }

    public function deleteAll()
    {
        Notification::where('user_id', Auth::id())->delete();
    }

    public function getNotifications()
    {
        $query = Notification::where('user_id', Auth::id());

        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('message', 'like', '%' . $this->searchTerm . '%');
            });
        }

        return $query->latest()->paginate(10);
    }

    public function getUnreadCount()
    {
        return Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    public function render()
    {
        return view('livewire.notifications.notification-center', [
            'notifications' => $this->getNotifications(),
            'unreadCount' => $this->getUnreadCount(),
        ]);
    }
}
