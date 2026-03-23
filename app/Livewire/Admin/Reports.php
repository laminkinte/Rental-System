<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Property;
use App\Models\User;
use App\Models\Review;
use App\Exports\AdminReportExport;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class Reports extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Date Range
    public $dateRange = 'custom';
    public $startDate;
    public $endDate;
    
    // Filters
    public $reportType = 'overview';
    public $statusFilter = '';
    public $propertyFilter = '';
    public $userFilter = '';
    public $typeFilter = '';
    public $roleFilter = '';
    public $verifiedFilter = '';
    
    // Properties list for filter
    public $properties = [];
    public $users = [];

    public function mount()
    {
        $user = auth()->user();
        
        // Check permission for viewing admin reports
        if ($user && !$user->hasPermission('view_admin_reports') && !$user->isSuperAdmin()) {
            abort(403, 'You do not have permission to view admin reports.');
        }
        
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->loadFilterOptions();
    }

    public function loadFilterOptions()
    {
        $this->properties = Property::orderBy('title')->get();
        $this->users = User::orderBy('name')->get();
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
        $this->userFilter = '';
        $this->typeFilter = '';
        $this->roleFilter = '';
        $this->verifiedFilter = '';
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
            'user_id' => $this->userFilter,
            'type' => $this->typeFilter,
            'role' => $this->roleFilter,
            'verified' => $this->verifiedFilter,
        ];
    }

    public function getOverviewStats()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        $stats = [
            'totalBookings' => Booking::whereBetween('created_at', [$startDate, $endDate])->count(),
            'totalRevenue' => Payment::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'completed')
                ->sum('amount'),
            'totalUsers' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'totalProperties' => Property::whereBetween('created_at', [$startDate, $endDate])->count(),
            'averageRating' => Review::whereBetween('created_at', [$startDate, $endDate])->avg('overall_rating') ?? 0,
            'cancellationRate' => $this->calculateCancellationRate(),
            'occupancyRate' => $this->calculateOccupancyRate(),
            'newHosts' => User::whereBetween('created_at', [$startDate, $endDate])
                ->where('is_host', true)
                ->count(),
        ];

        return $stats;
    }

    public function getBookingsByStatus()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        return Booking::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    public function getRevenueByMonth()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        return Payment::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->toArray();
    }

    public function getTopProperties()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        return Property::withCount(['bookings' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])
        ->withSum(['bookings' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }], 'total_amount')
        ->orderBy('bookings_count', 'desc')
        ->take(10)
        ->get();
    }

    public function getTopHosts()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        return User::where('is_host', true)
            ->withCount(['properties', 'bookingsAsHost' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->withSum(['bookingsAsHost' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }], 'total_amount')
            ->orderBy('bookings_as_host_count', 'desc')
            ->take(10)
            ->get();
    }

    public function getBookingsTrend()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        return Booking::whereBetween('created_at', [$startDate, $endDate])
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
        
        return Payment::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->limit(30)
            ->get()
            ->toArray();
    }

    public function getPreviewData()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $filters = $this->getFilters();

        return match($this->reportType) {
            'bookings' => Booking::with(['user', 'property'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->when($filters['status'], fn($q) => $q->where('status', $filters['status']))
                ->when($filters['property_id'], fn($q) => $q->where('property_id', $filters['property_id']))
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'revenue' => Payment::with(['booking.property', 'booking.user'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'completed')
                ->when($filters['property_id'], fn($q) => $q->whereHas('booking', fn($bq) => $bq->where('property_id', $filters['property_id'])))
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'users' => User::whereBetween('created_at', [$startDate, $endDate])
                ->when($filters['role'] === 'host', fn($q) => $q->where('is_host', true))
                ->when($filters['role'] === 'guest', fn($q) => $q->where('is_host', false))
                ->when($filters['verified'], fn($q) => $q->whereNotNull('email_verified_at'))
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'properties' => Property::with(['host'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->when($filters['status'] === 'active', fn($q) => $q->where('is_active', true))
                ->when($filters['status'] === 'inactive', fn($q) => $q->where('is_active', false))
                ->when($filters['type'], fn($q) => $q->where('property_type', $filters['type']))
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'hosts' => User::where('is_host', true)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->withCount(['properties', 'bookingsAsHost'])
                ->withSum(['bookingsAsHost'], 'total_amount')
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            default => null,
        };
    }

    private function calculateCancellationRate()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        $total = Booking::whereBetween('created_at', [$startDate, $endDate])->count();
        if ($total === 0) return 0;
        
        $cancelled = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'cancelled')
            ->count();
        
        return round(($cancelled / $total) * 100, 2);
    }

    private function calculateOccupancyRate()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        $totalProperties = Property::count();
        if ($totalProperties === 0) return 0;

        $occupied = Booking::whereBetween('check_in', [$startDate, $endDate])
            ->orWhereBetween('check_out', [$startDate, $endDate])
            ->distinct('property_id')
            ->count('property_id');

        return round(($occupied / $totalProperties) * 100, 2);
    }

    public function exportExcel()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $filters = $this->getFilters();
        
        $fileName = 'admin_' . $this->reportType . '_report_' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(
            new AdminReportExport($this->reportType, $startDate, $endDate, $filters),
            $fileName
        );
    }

    public function render()
    {
        $overviewStats = $this->getOverviewStats();
        $bookingsByStatus = $this->getBookingsByStatus();
        $revenueByMonth = $this->getRevenueByMonth();
        $topProperties = $this->getTopProperties();
        $topHosts = $this->getTopHosts();
        $bookingsTrend = $this->getBookingsTrend();
        $revenueTrend = $this->getRevenueTrend();
        $previewData = $this->getPreviewData();

        return view('livewire.admin.reports', [
            'overviewStats' => $overviewStats,
            'bookingsByStatus' => $bookingsByStatus,
            'revenueByMonth' => $revenueByMonth,
            'topProperties' => $topProperties,
            'topHosts' => $topHosts,
            'bookingsTrend' => $bookingsTrend,
            'revenueTrend' => $revenueTrend,
            'previewData' => $previewData,
        ]);
    }
}
