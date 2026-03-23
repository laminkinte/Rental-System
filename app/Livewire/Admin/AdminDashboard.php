<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDashboard extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $selectedMetric = 'overview';
    public $startDate;
    public $endDate;
    public $filterStatus = 'all';
    
    // Pagination
    protected $usersPagination = 'usersPage';
    protected $propertiesPagination = 'propertiesPage';
    protected $bookingsPagination = 'bookingsPage';

    public function mount()
    {
        $this->startDate = now()->subMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function setTab($tab)
    {
        $this->selectedMetric = $tab;
        $this->resetPage('fraudPage');
        $this->resetPage('disputesPage');
        $this->resetPage('usersPage');
        $this->resetPage('propertiesPage');
        $this->resetPage('bookingsPage');
    }

    public function getMetrics()
    {
        $bookingsCount = Booking::count();
        $revenue = Payment::where('status', 'completed')->sum('amount');
        $usersCount = User::count();
        $avgRating = Review::avg('overall_rating') ?? 0;
        $fraudAlertsCount = $this->getSuspiciousTransactionsQuery()->count();
        $propertiesCount = Property::count();
        $activeHosts = User::where('role', 'host')->count();
        $pendingPayouts = Booking::where('payout_status', 'pending')->count();

        return compact('bookingsCount', 'revenue', 'usersCount', 'avgRating', 'fraudAlertsCount', 'propertiesCount', 'activeHosts', 'pendingPayouts');
    }

    private function getSuspiciousTransactionsQuery()
    {
        return Payment::with('user')->where(function($q) {
            $q->where('status', 'pending')
              ->orWhere('amount', '>', 50000)
              ->orWhere('created_at', '<', now()->subDays(7));
        });
    }

    public function getSuspiciousTransactions()
    {
        return $this->getSuspiciousTransactionsQuery()->latest()->paginate(15, ['*'], 'fraudPage');
    }

    public function getFraudScore($payment)
    {
        $score = 0;
        $user = $payment->user;
        $reasons = [];

        if (!$user) {
            return ['score' => 0, 'reasons' => ['User not found.']];
        }

        $failedAttempts = Payment::where('user_id', $user->id)
            ->where('status', 'failed')
            ->whereDate('created_at', today())
            ->count();

        if ($failedAttempts > 3) {
            $score += 30;
            $reasons[] = "Multiple failed transactions today ($failedAttempts)";
        }

        $avgAmount = Payment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->avg('amount') ?? 0;

        if ($payment->amount > $avgAmount * 3 && $avgAmount > 0) {
            $score += 25;
            $reasons[] = "Amount 3x higher than user average";
        }

        if ($user->created_at > now()->subDays(7)) {
            $score += 20;
            $reasons[] = "New account (less than 7 days)";
        }

        $recentTransactions = Payment::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->count();

        if ($recentTransactions > 5) {
            $score += 15;
            $reasons[] = "High transaction velocity today ($recentTransactions)";
        }

        return ['score' => min($score, 100), 'reasons' => $reasons];
    }

    public function getPendingPayouts()
    {
        return User::where('role', 'host')
            ->whereHas('bookingsAsHost', function ($query) {
                $query->where('payout_status', 'pending');
            })
            ->withCount(['bookingsAsHost as pending_payouts_count' => function ($query) {
                $query->where('payout_status', 'pending');
            }])
            ->get();
    }

    public function getPaymentDisputes()
    {
        return Booking::with(['user', 'property'])
            ->where('disputed', true)
            ->latest()
            ->paginate(15, ['*'], 'disputesPage');
    }

    public function getRecentActivity()
    {
        return \App\Models\Notification::with('user')
            ->latest()
            ->take(20)
            ->get();
    }

    public function approvePayout($hostId)
    {
        $host = User::findOrFail($hostId);
        $count = Booking::where('host_id', $host->id)
            ->where('payout_status', 'pending')
            ->update(['payout_status' => 'approved']);

        session()->flash('success', "$count bookings marked for payout to {$host->name}");
    }

    public function flagAsFraud($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->update(['fraud_flagged' => true]);

        session()->flash('warning', 'Payment flagged for review');
    }

    public function resolveDispute($bookingId, $resolution)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->update([
            'disputed' => false,
            'dispute_resolution' => $resolution,
        ]);

        if ($resolution === 'refund_guest') {
            Payment::where('booking_id', $bookingId)
                ->where('status', 'completed')
                ->first()?->update(['status' => 'refunded']);
        }

        session()->flash('success', 'Dispute resolved successfully');
    }

    public function banUser($userId, $reason)
    {
        User::findOrFail($userId)->update(['banned' => true, 'ban_reason' => $reason]);
        session()->flash('warning', 'User banned successfully');
    }

    public function suspendListing($propertyId, $reason)
    {
        Property::findOrFail($propertyId)->update(['status' => 'suspended', 'suspension_reason' => $reason]);
        session()->flash('warning', 'Listing suspended');
    }

    public function viewUser($userId)
    {
        $this->dispatch('viewUser', $userId);
    }

    public function toggleUserStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['is_active' => !$user->is_active]);
        session()->flash('success', 'User status updated successfully');
    }

    public function togglePropertyStatus($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $property->update(['is_active' => !$property->is_active]);
        session()->flash('success', 'Property status updated successfully');
    }

    public function viewBooking($bookingId)
    {
        $this->dispatch('viewBooking', $bookingId);
    }

    public function render()
    {
        $metrics = $this->getMetrics();
        
        $suspicious = [];
        $disputes = [];
        $payouts = [];
        $allUsers = [];
        $allProperties = [];
        $allBookings = [];
        
        if ($this->selectedMetric === 'fraud') {
            $suspicious = $this->getSuspiciousTransactions();
            $suspicious->getCollection()->transform(function ($payment) {
                $payment->fraud_score = $this->getFraudScore($payment);
                return $payment;
            });
        }

        if ($this->selectedMetric === 'disputes') {
            $disputes = $this->getPaymentDisputes();
        }

        if ($this->selectedMetric === 'payouts') {
            $payouts = $this->getPendingPayouts();
        }
        
        if ($this->selectedMetric === 'users') {
            $allUsers = User::with('profile')->latest()->paginate(15, ['*'], 'usersPage');
        }
        
        if ($this->selectedMetric === 'properties') {
            $allProperties = Property::with('host')->latest()->paginate(15, ['*'], 'propertiesPage');
        }
        
        if ($this->selectedMetric === 'bookings') {
            $allBookings = Booking::with(['user', 'property'])->latest()->paginate(15, ['*'], 'bookingsPage');
        }

        return view('livewire.admin.admin-dashboard', [
            'metrics' => $metrics,
            'suspicious' => $suspicious,
            'disputes' => $disputes,
            'payouts' => $payouts,
            'allUsers' => $allUsers,
            'allProperties' => $allProperties,
            'allBookings' => $allBookings,
        ]);
    }
}
