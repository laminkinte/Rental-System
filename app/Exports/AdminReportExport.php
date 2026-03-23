<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Property;
use App\Models\User;
use App\Models\Review;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class AdminReportExport implements FromCollection, WithHeadings, WithStyles
{
    protected $reportType;
    protected $startDate;
    protected $endDate;
    protected $filters;

    public function __construct($reportType = 'overview', $startDate = null, $endDate = null, $filters = [])
    {
        $this->reportType = $reportType;
        $this->startDate = $startDate ? Carbon::parse($startDate) : now()->subDays(30)->startOfDay();
        $this->endDate = $endDate ? Carbon::parse($endDate) : now()->endOfDay();
        $this->filters = $filters;
    }

    public function collection()
    {
        return match($this->reportType) {
            'bookings' => $this->getBookingsData(),
            'revenue' => $this->getRevenueData(),
            'users' => $this->getUsersData(),
            'properties' => $this->getPropertiesData(),
            'hosts' => $this->getHostsData(),
            default => $this->getOverviewData(),
        };
    }

    private function getBookingsData()
    {
        $query = Booking::with(['user', 'property'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['property_id'])) {
            $query->where('property_id', $this->filters['property_id']);
        }

        $bookings = $query->get();

        return $bookings->map(function ($booking) {
            return [
                'ID' => $booking->id,
                'Guest' => $booking->user->name ?? 'N/A',
                'Property' => $booking->property->title ?? 'N/A',
                'Check In' => $booking->check_in ? Carbon::parse($booking->check_in)->format('Y-m-d') : 'N/A',
                'Check Out' => $booking->check_out ? Carbon::parse($booking->check_out)->format('Y-m-d') : 'N/A',
                'Guests' => $booking->num_guests ?? 0,
                'Total Amount' => number_format($booking->total_amount ?? 0, 2),
                'Status' => ucfirst($booking->status ?? 'N/A'),
                'Created' => $booking->created_at ? Carbon::parse($booking->created_at)->format('Y-m-d H:i') : 'N/A',
            ];
        });
    }

    private function getRevenueData()
    {
        $payments = Payment::with(['booking', 'booking.property', 'booking.user'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->where('status', 'completed');

        if (!empty($this->filters['property_id'])) {
            $payments->whereHas('booking', function($q) {
                $q->where('property_id', $this->filters['property_id']);
            });
        }

        $payments = $payments->get();

        return $payments->map(function ($payment) {
            return [
                'ID' => $payment->id,
                'Booking ID' => $payment->booking_id ?? 'N/A',
                'Guest' => $payment->booking?->user?->name ?? 'N/A',
                'Property' => $payment->booking?->property?->title ?? 'N/A',
                'Amount' => number_format($payment->amount ?? 0, 2),
                'Payment Method' => ucfirst($payment->payment_method ?? 'N/A'),
                'Transaction ID' => $payment->transaction_id ?? 'N/A',
                'Date' => $payment->created_at ? Carbon::parse($payment->created_at)->format('Y-m-d H:i') : 'N/A',
            ];
        });
    }

    private function getUsersData()
    {
        $query = User::whereBetween('created_at', [$this->startDate, $this->endDate]);

        if (!empty($this->filters['role'])) {
            if ($this->filters['role'] === 'host') {
                $query->where('is_host', true);
            } elseif ($this->filters['role'] === 'guest') {
                $query->where('is_host', false);
            }
        }
        if (!empty($this->filters['verified'])) {
            $query->where('email_verified_at', '!=', null);
        }

        $users = $query->get();

        return $users->map(function ($user) {
            return [
                'ID' => $user->id,
                'Name' => $user->name ?? 'N/A',
                'Email' => $user->email ?? 'N/A',
                'Phone' => $user->phone ?? 'N/A',
                'Role' => $user->is_host ? 'Host' : 'Guest',
                'Verified' => $user->email_verified_at ? 'Yes' : 'No',
                'Created' => $user->created_at ? Carbon::parse($user->created_at)->format('Y-m-d H:i') : 'N/A',
            ];
        });
    }

    private function getPropertiesData()
    {
        $query = Property::with(['host'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['type'])) {
            $query->where('property_type', $this->filters['type']);
        }

        $properties = $query->get();

        return $properties->map(function ($property) {
            return [
                'ID' => $property->id,
                'Title' => $property->title ?? 'N/A',
                'Type' => ucfirst($property->property_type ?? 'N/A'),
                'Location' => $property->location ?? 'N/A',
                'Host' => $property->host->name ?? 'N/A',
                'Price/Night' => number_format($property->price_per_night ?? 0, 2),
                'Status' => ucfirst($property->status ?? 'N/A'),
                'Created' => $property->created_at ? Carbon::parse($property->created_at)->format('Y-m-d') : 'N/A',
            ];
        });
    }

    private function getHostsData()
    {
        $hosts = User::where('is_host', true)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->withCount(['properties', 'bookingsAsHost'])
            ->withSum(['bookingsAsHost'], 'total_amount')
            ->get();

        return $hosts->map(function ($host) {
            return [
                'ID' => $host->id,
                'Name' => $host->name ?? 'N/A',
                'Email' => $host->email ?? 'N/A',
                'Phone' => $host->phone ?? 'N/A',
                'Properties' => $host->properties_count ?? 0,
                'Total Bookings' => $host->bookings_as_host_count ?? 0,
                'Total Revenue' => number_format($host->bookings_as_host_sum_total_amount ?? 0, 2),
                'Created' => $host->created_at ? Carbon::parse($host->created_at)->format('Y-m-d') : 'N/A',
            ];
        });
    }

    private function getOverviewData()
    {
        $stats = [
            'Report Period' => $this->startDate->format('Y-m-d') . ' to ' . $this->endDate->format('Y-m-d'),
            'Total Bookings' => Booking::whereBetween('created_at', [$this->startDate, $this->endDate])->count(),
            'Total Revenue' => number_format(Payment::whereBetween('created_at', [$this->startDate, $this->endDate])->where('status', 'completed')->sum('amount'), 2),
            'Total Users' => User::whereBetween('created_at', [$this->startDate, $this->endDate])->count(),
            'New Hosts' => User::whereBetween('created_at', [$this->startDate, $this->endDate])->where('is_host', true)->count(),
            'Total Properties' => Property::whereBetween('created_at', [$this->startDate, $this->endDate])->count(),
            'Average Rating' => number_format(Review::whereBetween('created_at', [$this->startDate, $this->endDate])->avg('overall_rating') ?? 0, 1),
            'Cancellation Rate' => $this->calculateCancellationRate() . '%',
            'Occupancy Rate' => $this->calculateOccupancyRate() . '%',
        ];

        return collect([$stats])->map(function ($item, $key) {
            return $item;
        })->values();
    }

    private function calculateCancellationRate()
    {
        $total = Booking::whereBetween('created_at', [$this->startDate, $this->endDate])->count();
        if ($total === 0) return 0;
        $cancelled = Booking::whereBetween('created_at', [$this->startDate, $this->endDate])->where('status', 'cancelled')->count();
        return round(($cancelled / $total) * 100, 2);
    }

    private function calculateOccupancyRate()
    {
        $totalProperties = Property::count();
        if ($totalProperties === 0) return 0;
        $occupied = Booking::whereBetween('check_in', [$this->startDate, $this->endDate])
            ->orWhereBetween('check_out', [$this->startDate, $this->endDate])
            ->distinct('property_id')
            ->count('property_id');
        return round(($occupied / $totalProperties) * 100, 2);
    }

    public function headings(): array
    {
        return match($this->reportType) {
            'bookings' => ['ID', 'Guest', 'Property', 'Check In', 'Check Out', 'Guests', 'Total Amount', 'Status', 'Created'],
            'revenue' => ['ID', 'Booking ID', 'Guest', 'Property', 'Amount', 'Payment Method', 'Transaction ID', 'Date'],
            'users' => ['ID', 'Name', 'Email', 'Phone', 'Role', 'Verified', 'Created'],
            'properties' => ['ID', 'Title', 'Type', 'Location', 'Host', 'Price/Night', 'Status', 'Created'],
            'hosts' => ['ID', 'Name', 'Email', 'Phone', 'Properties', 'Total Bookings', 'Total Revenue', 'Created'],
            default => ['Metric', 'Value'],
        };
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E2E8F0']]],
        ];
    }
}
