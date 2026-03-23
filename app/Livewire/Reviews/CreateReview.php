<?php

namespace App\Livewire\Reviews;

use App\Models\Booking;
use App\Models\Review;
use Livewire\Component;

class CreateReview extends Component
{
    public $bookingId;
    public $booking;
    public $overall_rating;
    public $cleanliness_rating;
    public $communication_rating;
    public $location_rating;
    public $value_rating;
    public $accuracy_rating;
    public $review_text;
    public $highlights = [];
    public $improvements = [];
    public $would_recommend = true;

    public function mount($bookingId)
    {
        $this->bookingId = $bookingId;
        $this->booking = Booking::find($bookingId);
        
        if (!$this->booking || ($this->booking->user_id !== auth()->id() && $this->booking->property->host_id !== auth()->id())) {
            abort(403);
        }
    }

    public function submit()
    {
        $this->validate([
            'overall_rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|min:10|max:2000',
            'highlights' => 'array',
            'improvements' => 'array',
        ]);

        Review::create([
            'booking_id' => $this->bookingId,
            'reviewer_id' => auth()->id(),
            'reviewee_id' => $this->booking->user_id === auth()->id() ? $this->booking->property->host_id : $this->booking->user_id,
            'review_type' => $this->booking->user_id === auth()->id() ? 'guest_to_host' : 'host_to_guest',
            'overall_rating' => $this->overall_rating,
            'cleanliness_rating' => $this->cleanliness_rating,
            'communication_rating' => $this->communication_rating,
            'location_rating' => $this->location_rating,
            'value_rating' => $this->value_rating,
            'accuracy_rating' => $this->accuracy_rating,
            'review_text' => $this->review_text,
            'highlights' => $this->highlights,
            'improvements' => $this->improvements,
            'would_recommend' => $this->would_recommend,
            'verified_stay' => true,
            'stay_date' => $this->booking->check_in,
        ]);

        return redirect()->route('bookings.show', $this->booking)
                       ->with('success', 'Review posted successfully!');
    }

    public function render()
    {
        return view('livewire.reviews.create-review');
    }
}
