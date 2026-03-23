<?php

namespace App\Livewire\Host;

use App\Models\Property;
use App\Models\Booking;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $user;
    public $properties;
    public $recent_bookings;
    public $earnings_this_month = 0;
    public $total_earnings = 0;
    public $active_listings = 0;
    public $response_rate = 0;
    public $average_rating = 0;
    public $superhost = false;

    public function mount()
    {
        $this->user = auth()->user();
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $this->properties = Property::where('host_id', $this->user->id)->get();
        $this->active_listings = $this->properties->where('is_active', true)->count();

        $this->recent_bookings = Booking::whereIn('property_id', $this->properties->pluck('id'))
            ->with('property', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $now = now();
        $month_start = $now->clone()->startOfMonth();
        $month_end = $now->clone()->endOfMonth();

        $this->earnings_this_month = $this->properties
            ->map(function ($property) use ($month_start, $month_end) {
                return $property->bookings()
                    ->where('status', 'confirmed')
                    ->whereBetween('confirmed_at', [$month_start, $month_end])
                    ->sum('total_amount');
            })
            ->sum() * 0.85; // 85% after platform fee

        $this->total_earnings = $this->properties
            ->map(function ($property) {
                return $property->bookings()
                    ->where('status', 'confirmed')
                    ->sum('total_amount');
            })
            ->sum() * 0.85;

        // Calculate response rate (percentage of messages responded to within 24h)
        $this->response_rate = 80; // Placeholder

        // Calculate average rating
        $reviews = $this->recent_bookings->map(fn($booking) => $booking->reviews()->first());
        $ratings = $reviews->filter()->pluck('overall_rating');
        $this->average_rating = $ratings->count() > 0 ? $ratings->avg() : 0;

        // Superhost criteria: >4.8 rating, >90% response rate, <1% cancellation, >10 stays/year
        $this->superhost = $this->average_rating >= 4.8 && $this->response_rate >= 90;
    }

    public function render()
    {
        return view('livewire.host.dashboard', [
            'user' => $this->user,
        ]);
    }
}
