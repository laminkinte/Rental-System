<?php

namespace App\Livewire\Properties;

use App\Models\Property;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class Show extends Component
{
    public Property $property;
    public $check_in;
    public $check_out;
    public $guests = 1;
    public $total_nights = 0;
    public $subtotal = 0;
    public $cleaning_fee = 0;
    public $service_fee = 0;
    public $total = 0;
    public $error = null;

    public function mount(Property $property)
    {
        // Check if property exists
        if (!$property || !$property->id) {
            return redirect()->route('properties.search');
        }
        
        $this->property = $property->load('host', 'bookings');
        $this->cleaning_fee = $property->cleaning_fee ?? 0;
        $this->calculateTotal();
    }

    public function updatedCheckIn()
    {
        $this->calculateTotal();
    }

    public function updatedCheckOut()
    {
        $this->calculateTotal();
    }

    public function updatedGuests()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        if ($this->check_in && $this->check_out) {
            $checkIn = Carbon::parse($this->check_in);
            $checkOut = Carbon::parse($this->check_out);

            if ($checkOut->greaterThan($checkIn)) {
                $this->total_nights = $checkIn->diffInDays($checkOut);
                $this->subtotal = $this->total_nights * $this->property->base_price;
                $this->service_fee = round($this->subtotal * 0.12); // 12% service fee
                $this->total = $this->subtotal + $this->cleaning_fee + $this->service_fee;
            }
        }
    }

    public function book()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            $this->addError('booking', 'Please login to make a booking.');
            return redirect()->route('login')->with('error', 'Please login to make a booking.');
        }

        $this->validate([
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:' . $this->property->guest_capacity,
        ]);

        // Check availability
        $existingBooking = Booking::where('property_id', $this->property->id)
            ->where(function ($query) {
                $query->whereBetween('check_in', [$this->check_in, $this->check_out])
                      ->orWhereBetween('check_out', [$this->check_in, $this->check_out])
                      ->orWhere(function ($q) {
                          $q->where('check_in', '<=', $this->check_in)
                            ->where('check_out', '>=', $this->check_out);
                      });
            })
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($existingBooking) {
            $this->addError('booking', 'Property is not available for the selected dates.');
            return;
        }

        // Create booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'property_id' => $this->property->id,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'guests' => $this->guests,
            'total_nights' => $this->total_nights,
            'subtotal' => $this->subtotal,
            'cleaning_fee' => $this->cleaning_fee,
            'service_fee' => $this->service_fee,
            'total_amount' => $this->total,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking request submitted successfully!');
    }

    public function render()
    {
        return view('livewire.properties.show');
    }
}