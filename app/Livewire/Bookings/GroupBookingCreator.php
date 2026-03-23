<?php

namespace App\Livewire\Bookings;

use App\Models\Property;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class GroupBookingCreator extends Component
{
    public $currentStep = 1;

    // Step 1: Basics
    public $title = '';
    public $description = '';
    public $guestCount = 2;

    // Step 2: Members
    public $memberEmail = '';
    public $members = [];

    // Step 3: Properties & Dates
    public $propertySelection = 'single';
    public $selectedProperties = [];
    public $checkIn = '';
    public $checkOut = '';
    public $totalAmount = 0.0;

    // Step 4: Payment
    public $splitType = 'equal';
    public $splitPayment = [];

    protected function rules()
    {
        return [
            1 => [
                'title' => 'required|string|min:3|max:255',
                'description' => 'required|string|max:1000',
                'guestCount' => 'required|integer|min:2|max:50',
            ],
            2 => [
                'members' => 'array',
            ],
            3 => [
                'selectedProperties' => 'required|array|min:1',
                'checkIn' => 'required|date|after:today',
                'checkOut' => 'required|date|after:checkIn',
            ],
            4 => [
                'splitType' => 'required|in:equal,custom,organizer_pays',
            ],
        ][$this->currentStep] ?? [];
    }

    public function addMember()
    {
        $this->validate(['memberEmail' => 'required|email']);

        if ($this->memberEmail === Auth::user()->email) {
            $this->addError('memberEmail', 'You are the organizer and already included.');
            return;
        }

        if (collect($this->members)->contains('email', $this->memberEmail)) {
            $this->addError('memberEmail', 'This member has already been added.');
            return;
        }

        $this->members[] = ['email' => $this->memberEmail];
        $this->memberEmail = '';
    }

    public function removeMember($email)
    {
        $this->members = collect($this->members)
            ->reject(fn($member) => $member['email'] === $email)
            ->values()
            ->toArray();
    }

    public function nextStep()
    {
        $this->validate($this->rules());

        if ($this->currentStep === 3) {
            $this->calculateTotal();
            $this->calculateSplit();
        }

        $this->currentStep++;
    }

    public function prevStep()
    {
        $this->currentStep--;
    }

    public function calculateTotal()
    {
        if (!$this->checkIn || !$this->checkOut || empty($this->selectedProperties)) {
            $this->totalAmount = 0;
            return;
        }

        $start = strtotime($this->checkIn);
        $end = strtotime($this->checkOut);
        $days = max(1, ceil(($end - $start) / 86400));

        $basePriceTotal = Property::whereIn('id', $this->selectedProperties)->sum('base_price');
        
        $this->totalAmount = $basePriceTotal * $days;
    }

    public function updatedSplitType()
    {
        $this->calculateSplit();
    }

    public function calculateSplit()
    {
        $participants = count($this->members) + 1; // Members + Organizer
        
        if ($this->splitType === 'organizer_pays') {
            $this->splitPayment = ['organizer' => $this->totalAmount];
            foreach ($this->members as $member) {
                $this->splitPayment[$member['email']] = 0;
            }
        } else {
            $share = $this->totalAmount / max(1, $participants);
            $this->splitPayment = ['organizer' => $share];
            foreach ($this->members as $member) {
                $this->splitPayment[$member['email']] = $share;
            }
        }
    }

    public function saveGroupBooking()
    {
        $this->validate($this->rules());

        // Logic to save group booking would go here
        // 1. Create GroupBooking record
        // 2. Create Bookings for properties
        // 3. Send invites/payment requests

        session()->flash('success', 'Group booking created successfully!');
        
        return redirect()->route('bookings.index');
    }

    public function render()
    {
        return view('livewire.bookings.group-booking-creator', [
            'properties' => Property::where('is_active', true)->get(),
        ]);
    }
}