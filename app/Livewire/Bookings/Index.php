<?php

namespace App\Livewire\Bookings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class Index extends Component
{
    public $bookings = [];
    public $activeTab = 'upcoming';

    public function mount()
    {
        $this->loadBookings();
    }

    public function loadBookings()
    {
        $userId = Auth::id();
        
        $query = Booking::with(['property', 'user'])
            ->where('user_id', $userId)
            ->orderBy('check_in', 'desc');

        if ($this->activeTab === 'upcoming') {
            $query->where('check_in', '>=', now()->toDateString());
        } elseif ($this->activeTab === 'past') {
            $query->where('check_out', '<', now()->toDateString());
        }

        $this->bookings = $query->get();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadBookings();
    }

    public function render()
    {
        return view('livewire.bookings.index');
    }
}
