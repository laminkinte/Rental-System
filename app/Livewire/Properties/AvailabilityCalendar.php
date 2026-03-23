<?php

namespace App\Livewire\Properties;

use App\Models\Property;
use App\Models\Booking;
use Carbon\Carbon;
use Livewire\Component;

class AvailabilityCalendar extends Component
{
    public Property $property;
    
    public $currentMonth;
    public $currentYear;
    public $checkIn = null;
    public $checkOut = null;
    public $selecting = 'checkin';
    
    protected $listeners = ['dateSelected' => 'handleDateSelection'];
    
    public function mount(Property $property)
    {
        $this->property = $property;
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
    }
    
    public function previousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }
    
    public function nextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }
    
    public function selectDate($date)
    {
        $date = Carbon::parse($date);
        
        if ($this->selecting === 'checkin') {
            $this->checkIn = $date->format('Y-m-d');
            $this->checkOut = null;
            $this->selecting = 'checkout';
        } else {
            if ($date->lt(Carbon::parse($this->checkIn))) {
                $this->checkIn = $date->format('Y-m-d');
                $this->selecting = 'checkout';
                return;
            }
            
            // Check if any booked dates are between check-in and check-out
            $bookedDates = $this->getBookedDates();
            $range = Carbon::parse($this->checkIn)->toCarbonPeriod(Carbon::parse($this->checkIn)->addDay());
            for ($i = 1; $i <= 365; $i++) {
                $d = Carbon::parse($this->checkIn)->addDays($i);
                if ($d->eq($date)) break;
                if (in_array($d->format('Y-m-d'), $bookedDates)) {
                    $this->checkIn = $date->format('Y-m-d');
                    $this->selecting = 'checkout';
                    return;
                }
            }
            
            $this->checkOut = $date->format('Y-m-d');
            $this->selecting = 'checkin';
            
            // Emit event to parent
            $this->dispatch('datesSelected', [
                'checkIn' => $this->checkIn,
                'checkOut' => $this->checkOut
            ]);
        }
    }
    
    public function clearDates()
    {
        $this->checkIn = null;
        $this->checkOut = null;
        $this->selecting = 'checkin';
    }
    
    public function getBookedDates()
    {
        return Booking::where('property_id', $this->property->id)
            ->whereIn('status', ['confirmed', 'pending'])
            ->where('check_out', '>=', Carbon::now()->format('Y-m-d'))
            ->get()
            ->flatMap(function ($booking) {
                $dates = [];
                $current = Carbon::parse($booking->check_in);
                while ($current->lt(Carbon::parse($booking->check_out))) {
                    $dates[] = $current->format('Y-m-d');
                    $current->addDay();
                }
                return $dates;
            })
            ->toArray();
    }
    
    public function getMonthData()
    {
        $startOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $startDay = $startOfMonth->dayOfWeek;
        $daysInMonth = $endOfMonth->day;
        
        $bookedDates = $this->getBookedDates();
        $today = Carbon::now()->format('Y-m-d');
        
        $days = [];
        
        // Empty cells before first day
        for ($i = 0; $i < $startDay; $i++) {
            $days[] = null;
        }
        
        // Days of month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($this->currentYear, $this->currentMonth, $day);
            $dateStr = $date->format('Y-m-d');
            
            $isPast = $date->lt(Carbon::now()->startOfDay());
            $isBooked = in_array($dateStr, $bookedDates);
            $isCheckIn = $this->checkIn === $dateStr;
            $isCheckOut = $this->checkOut === $dateStr;
            $isInRange = $this->checkIn && $this->checkOut && 
                         $date->gt(Carbon::parse($this->checkIn)) && 
                         $date->lt(Carbon::parse($this->checkOut));
            
            $days[] = [
                'day' => $day,
                'date' => $dateStr,
                'isPast' => $isPast,
                'isBooked' => $isBooked,
                'isCheckIn' => $isCheckIn,
                'isCheckOut' => $isCheckOut,
                'isInRange' => $isInRange,
                'isToday' => $dateStr === $today,
            ];
        }
        
        return $days;
    }
    
    public function getCalendarWeeks()
    {
        $days = $this->getMonthData();
        $weeks = [];
        $week = [];
        
        foreach ($days as $day) {
            $week[] = $day;
            if (count($week) === 7) {
                $weeks[] = $week;
                $week = [];
            }
        }
        
        // Fill remaining days
        while (count($week) < 7 && count($week) > 0) {
            $week[] = null;
        }
        if (count($week) > 0) {
            $weeks[] = $week;
        }
        
        return $weeks;
    }
    
    public function getNightsCount()
    {
        if (!$this->checkIn || !$this->checkOut) return 0;
        return Carbon::parse($this->checkIn)->diffInDays(Carbon::parse($this->checkOut));
    }
    
    public function render()
    {
        $monthName = Carbon::create($this->currentYear, $this->currentMonth, 1)->format('F Y');
        
        return view('livewire.properties.availability-calendar', [
            'weeks' => $this->getCalendarWeeks(),
            'monthName' => $monthName,
            'nights' => $this->getNightsCount(),
        ]);
    }
}
