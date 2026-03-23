<?php

namespace App\Livewire\Host;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Review;
use App\Models\User;
use App\Exports\HostReportExport;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HostReports extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $dateRange = 'custom';
    public $startDate;
    public $endDate;
    public $hostId;
    
    // Filters
    public $reportType = 'overview';
    public $statusFilter = '';
    public $propertyFilter = '';
    public $payoutStatusFilter = '';
    
    // Properties list for filter
    public $properties = [];

    public function mount()
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            abort(403, 'You must be logged in to view host reports.');
        }
        
        // Check if user is a host (has properties)
        $hasProperties = Property::where('host_id', $user->id)->exists();
        
        if (!$hasProperties) {
            abort(403, 'You do not have permission to view host reports.');
        }
        
        $this->hostId = Auth::id();
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->loadFilterOptions();
    }

    public function loadFilterOptions()
    {
        $this->properties = Property::where('host_id', $this->hostId)
            ->orderBy('title')
            ->get();
    }

    public function setDateRange($range)
    {
        $this->dateRange = $range;
        
        switch ($range) {
            case '7':
                $this->startDate = now()->subDays(7)->format('Y-m-d');
                $this->endDate = now()->format('Y-m-d');
                break;
            case '30':
                $this->startDate = now()->subDays(30)->format('Y-m-d');
                $this->endDate = now()->format('Y-m-d');
                break;
            case '90':
                $this->startDate = now()->subDays(90)->format('Y-m-d');
                $this->endDate = now()->format('Y-m-d');
                break;
            case '365':
                $this->startDate = now()->subDays(365)->format('Y-m-d');
                $this->endDate = now()->format('Y-m-d');
                break;
            case 'this_month':
                $this->startDate = now()->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->format('Y-m-d');
                break;
            case 'last_month':
                $this->startDate = now()->subMonth()->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->subMonth()->endOfMonth()->format('Y-m-d');
                break;
            case 'this_year':
                $this->startDate = now()->startOfYear()->format('Y-m-d');
                $this->endDate = now()->format('Y-m-d');
                break;
        }
        
        $this->resetPage();
    }

    public function updatedDateRange()
    {
        if ($this->dateRange !== 'custom') {
            $this->setDateRange($this->dateRange);
        }
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->statusFilter = '';
        $this->propertyFilter = '';
        $this->payoutStatusFilter = '';
        $this->dateRange = '30';
        $this->setDateRange('30');
    }

    private function getDateRange()
    {
        return [
            Carbon::parse($this->startDate)->startOfDay(),
            Carbon::parse($this->endDate)->endOfDay()
        ];
    }

    private function getFilters()
    {
        return [
            'status' => $this->statusFilter,
            'property_id' => $this->propertyFilter,
            'payout_status' => $this->payoutStatusFilter,
        ];
    }

    private function getHostProperties()
    {
        return Property::where('host_id', $this->hostId)->get();
    }

    private function getHostPropertyIds()
    {
        return $this->getHostProperties()->pluck('id');
    }

    public function getOverviewStats()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $propertyIds = $this->getHostPropertyIds();

        if ($propertyIds->isEmpty()) {
            return [
                'totalBookings' => 0,
                'totalRevenue' => 0,
                'pendingPayouts' => 0,
                'averageRating' => 0,
                'cancellationRate' => 0,
                'occupancyRate' => 0,
                'totalProperties' => 0,
                'confirmedBookings' => 0,
            ];
        }

        $stats = [
            'totalBookings' => Booking::whereIn('property_id', $propertyIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'totalRevenue' => Booking::whereIn('property_id', $propertyIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['confirmed', 'completed'])
                ->sum('total_amount'),
            'pendingPayouts' => Booking::whereIn('property_id', $propertyIds)
                ->where('payout_status', 'pending')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_amount'),
            'averageRating' => $this->getAverageRating(),
            'cancellationRate' => $this->calculateCancellationRate($propertyIds),
            'occupancyRate' => $this->calculateOccupancyRate($propertyIds),
            'totalProperties' => $propertyIds->count(),
            'confirmedBookings' => Booking::whereIn('property_id', $propertyIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'confirmed')
                ->count(),
        ];

        return $stats;
    }

    public function getBookingsByStatus()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $propertyIds = $this->getHostPropertyIds();
        
        if ($propertyIds->isEmpty()) {
            return [];
        }
        
        return Booking::whereIn('property_id', $propertyIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    public function getRevenueByProperty()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $propertyIds = $this->getHostPropertyIds();
        
        if ($propertyIds->isEmpty()) {
            return collect();
        }
        
        $query = Property::whereIn('id', $propertyIds)
            ->withCount(['bookings' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                    ->whereIn('status', ['confirmed', 'completed']);
            }])
            ->withSum(['bookings' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                    ->whereIn('status', ['confirmed', 'completed']);
            }], 'total_amount');

        if (!empty($this->propertyFilter)) {
            $query->where('id', $this->propertyFilter);
        }
        
        return $query->orderBy('bookings_sum_total_amount', 'desc')->get();
    }

    public function getUpcomingBookings()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $propertyIds = $this->getHostPropertyIds();
        
        if ($propertyIds->isEmpty()) {
            return collect();
        }
        
        return Booking::whereIn('property_id', $propertyIds)
            ->where('status', 'confirmed')
            ->where('check_in', '>=', now())
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['user', 'property'])
            ->orderBy('check_in')
            ->take(10)
            ->get();
    }

    public function getRecentReviews()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $propertyIds = $this->getHostPropertyIds();
        
        if ($propertyIds->isEmpty()) {
            return collect();
        }
        
        // Get bookings first, then reviews
        $bookingIds = Booking::whereIn('property_id', $propertyIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->pluck('id');
        
        if ($bookingIds->isEmpty()) {
            return collect();
        }
        
        return Review::whereIn('booking_id', $bookingIds)
            ->with(['booking', 'booking.user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    }

    public function getBookingsTrend()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $propertyIds = $this->getHostPropertyIds();
        
        if ($propertyIds->isEmpty()) {
            return [];
        }
        
        return Booking::whereIn('property_id', $propertyIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->limit(30)
            ->get()
            ->toArray();
    }

    public function getRevenueTrend()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $propertyIds = $this->getHostPropertyIds();
        
        if ($propertyIds->isEmpty()) {
            return [];
        }
        
        return Booking::whereIn('property_id', $propertyIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['confirmed', 'completed'])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->limit(30)
            ->get()
            ->toArray();
    }

    public function getPayoutHistory()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $propertyIds = $this->getHostPropertyIds();
        
        if ($propertyIds->isEmpty()) {
            return collect();
        }
        
        $query = Booking::whereIn('property_id', $propertyIds)
            ->whereIn('payout_status', ['approved', 'paid', 'pending'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['property', 'user']);

        if (!empty($this->payoutStatusFilter)) {
            $query->where('payout_status', $this->payoutStatusFilter);
        }
        
        return $query->orderBy('created_at', 'desc')->take(20)->get();
    }

    public function getPreviewData()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $filters = $this->getFilters();
        $propertyIds = $this->getHostPropertyIds();

        if ($propertyIds->isEmpty()) {
            return null;
        }

        switch($this->reportType) {
            case 'bookings':
                return Booking::with(['user', 'property'])
                    ->whereIn('property_id', $propertyIds)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->when($filters['status'], fn($q) => $q->where('status', $filters['status']))
                    ->when($filters['property_id'], fn($q) => $q->where('property_id', $filters['property_id']))
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
                    
            case 'revenue':
                return Property::whereIn('id', $propertyIds)
                    ->when($filters['property_id'], fn($q) => $q->where('id', $filters['property_id']))
                    ->withCount(['bookings' => function ($q) use ($startDate, $endDate) {
                        $q->whereBetween('created_at', [$startDate, $endDate])
                            ->whereIn('status', ['confirmed', 'completed']);
                    }])
                    ->withSum(['bookings' => function ($q) use ($startDate, $endDate) {
                        $q->whereBetween('created_at', [$startDate, $endDate])
                            ->whereIn('status', ['confirmed', 'completed']);
                    }], 'total_amount')
                    ->orderBy('bookings_sum_total_amount', 'desc')
                    ->paginate(10);
                    
            case 'reviews':
                $bookingIds = Booking::whereIn('property_id', $propertyIds)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->pluck('id');
                    
                if ($bookingIds->isEmpty()) {
                    return collect();
                }
                
                return Review::whereIn('booking_id', $bookingIds)
                    ->with(['booking', 'booking.user'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
                    
            case 'payouts':
                return Booking::whereIn('property_id', $propertyIds)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->when($filters['payout_status'], fn($q) => $q->where('payout_status', $filters['payout_status']))
                    ->with(['property', 'user'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
                    
            default:
                return null;
        }
    }

    private function getAverageRating()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $propertyIds = $this->getHostPropertyIds();
        
        if ($propertyIds->isEmpty()) {
            return 0;
        }
        
        $bookingIds = Booking::whereIn('property_id', $propertyIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->pluck('id');
        
        if ($bookingIds->isEmpty()) {
            return 0;
        }
        
        $avgRating = Review::whereIn('booking_id', $bookingIds)->avg('overall_rating');
        
        return $avgRating ? round($avgRating, 2) : 0;
    }

    private function calculateCancellationRate($propertyIds)
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        $total = Booking::whereIn('property_id', $propertyIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        
        if ($total === 0) return 0;
        
        $cancelled = Booking::whereIn('property_id', $propertyIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'cancelled')
            ->count();
        
        return round(($cancelled / $total) * 100, 2);
    }

    private function calculateOccupancyRate($propertyIds)
    {
        if ($propertyIds->isEmpty()) return 0;
        
        [$startDate, $endDate] = $this->getDateRange();
        
        $totalProperties = $propertyIds->count();
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);
        $daysInRange = $start->diffInDays($end) + 1;
        $totalPropertyDays = $totalProperties * $daysInRange;

        // Calculate occupied days
        $occupiedDays = Booking::whereIn('property_id', $propertyIds)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('check_in', [$startDate, $endDate])
                      ->orWhereBetween('check_out', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('check_in', '<=', $startDate)
                            ->where('check_out', '>=', $endDate);
                      });
            })
            ->where('status', '!=', 'cancelled')
            ->get()
            ->sum(function ($booking) use ($startDate, $endDate) {
                $checkIn = Carbon::parse($booking->check_in)->max(Carbon::parse($startDate));
                $checkOut = Carbon::parse($booking->check_out)->min(Carbon::parse($endDate));
                return $checkIn->diffInDays($checkOut) + 1;
            });

        if ($totalPropertyDays === 0) return 0;
        
        return round(($occupiedDays / $totalPropertyDays) * 100, 2);
    }

    public function exportExcel()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $filters = $this->getFilters();
        
        $fileName = 'host_' . $this->reportType . '_report_' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(
            new HostReportExport($this->reportType, $startDate, $endDate, $this->hostId, $filters),
            $fileName
        );
    }

    public function render()
    {
        $overviewStats = $this->getOverviewStats();
        $bookingsByStatus = $this->getBookingsByStatus();
        $revenueByProperty = $this->getRevenueByProperty();
        $upcomingBookings = $this->getUpcomingBookings();
        $recentReviews = $this->getRecentReviews();
        $bookingsTrend = $this->getBookingsTrend();
        $revenueTrend = $this->getRevenueTrend();
        $payoutHistory = $this->getPayoutHistory();
        $previewData = $this->getPreviewData();

        return view('livewire.host.host-reports', [
            'overviewStats' => $overviewStats,
            'bookingsByStatus' => $bookingsByStatus,
            'revenueByProperty' => $revenueByProperty,
            'upcomingBookings' => $upcomingBookings,
            'recentReviews' => $recentReviews,
            'bookingsTrend' => $bookingsTrend,
            'revenueTrend' => $revenueTrend,
            'payoutHistory' => $payoutHistory,
            'previewData' => $previewData,
        ]);
    }
}