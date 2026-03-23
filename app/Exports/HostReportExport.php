<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\Property;
use App\Models\Review;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class HostReportExport implements FromCollection, WithHeadings, WithStyles
{
    protected $reportType;
    protected $startDate;
    protected $endDate;
    protected $hostId;
    protected $filters;

    public function __construct($reportType = 'overview', $startDate = null, $endDate = null, $hostId = null, $filters = [])
    {
        $this->reportType = $reportType;
        $this->startDate = $startDate ? Carbon::parse($startDate) : now()->subDays(30)->startOfDay();
        $this->endDate = $endDate ? Carbon::parse($endDate) : now()->endOfDay();
        $this->hostId = $hostId ?? auth()->id();
        $this->filters = $filters;
    }

    public function collection()
    {
        return match($this->reportType) {
            'bookings' => $this->getBookingsData(),
            'revenue' => $this->getRevenueData(),
            'reviews' => $this->getReviewsData(),
            'payouts' => $this->getPayoutsData(),
            default => $this->getOverviewData(),
        };
    }

    private function getHostPropertyIds()
    {
        return Property::where('host_id', $this->hostId)->pluck('id');
    }

    private function getBookingsData()
    {
        $propertyIds = $this->getHostPropertyIds();
        
        $query = Booking::with(['user', 'property'])
            ->whereIn('property_id', $propertyIds)
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
        $propertyIds = $this->getHostPropertyIds();

        $query = Property::whereIn('id', $propertyIds)
            ->withCount(['bookings' => function ($q) {
                $q->whereBetween('created_at', [$this->startDate, $this->endDate])
                    ->whereIn('status', ['confirmed', 'completed']);
            }])
            ->withSum(['bookings' => function ($q) {
                $q->whereBetween('created_at', [$this->startDate, $this->endDate])
                    ->whereIn('status', ['confirmed', 'completed']);
            }], 'total_amount');

        if (!empty($this->filters['property_id'])) {
            $query->where('id', $this->filters['property_id']);
        }

        $properties = $query->get();

        return $properties->map(function ($property) {
            return [
                'Property' => $property->title ?? 'N/A',
                'Location' => $property->location ?? 'N/A',
                'Total Bookings' => $property->bookings_count ?? 0,
                'Total Revenue' => number_format($property->bookings_sum_total_amount ?? 0, 2),
                'Average per Booking' => $property->bookings_count > 0 
                    ? number_format(($property->bookings_sum_total_amount ?? 0) / $property->bookings_count, 2)
                    : '0.00',
            ];
        });
    }

    private function getReviewsData()
    {
        $propertyIds = $this->getHostPropertyIds();

        $query = Review::whereIn('property_id', $propertyIds)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->with(['booking', 'reviewer']);

        $reviews = $query->get();

        return $reviews->map(function ($review) {
            return [
                'ID' => $review->id,
                'Property' => $review->property?->title ?? 'N/A',
                'Guest' => $review->reviewer->name ?? 'N/A',
                'Overall Rating' => number_format($review->overall_rating ?? 0, 1),
                'Cleanliness' => number_format($review->cleanliness ?? 0, 1),
                'Communication' => number_format($review->communication ?? 0, 1),
                'Location' => number_format($review->location ?? 0, 1),
                'Value' => number_format($review->value ?? 0, 1),
                'Comment' => $review->comment ?? 'No comment',
                'Date' => $review->created_at ? Carbon::parse($review->created_at)->format('Y-m-d') : 'N/A',
            ];
        });
    }

    private function getPayoutsData()
    {
        $propertyIds = $this->getHostPropertyIds();

        $query = Booking::whereIn('property_id', $propertyIds)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->whereIn('payout_status', ['approved', 'paid', 'pending']);

        if (!empty($this->filters['payout_status'])) {
            $query->where('payout_status', $this->filters['payout_status']);
        }

        $bookings = $query->get();

        return $bookings->map(function ($booking) {
            return [
                'Booking ID' => $booking->id,
                'Property' => $booking->property->title ?? 'N/A',
                'Guest' => $booking->user->name ?? 'N/A',
                'Check In' => $booking->check_in ? Carbon::parse($booking->check_in)->format('Y-m-d') : 'N/A',
                'Check Out' => $booking->check_out ? Carbon::parse($booking->check_out)->format('Y-m-d') : 'N/A',
                'Total Amount' => number_format($booking->total_amount ?? 0, 2),
                'Payout Amount' => number_format(($booking->total_amount ?? 0) * 0.8, 2), // Assuming 80% payout to host
                'Payout Status' => ucfirst($booking->payout_status ?? 'pending'),
                'Date' => $booking->created_at ? Carbon::parse($booking->created_at)->format('Y-m-d') : 'N/A',
            ];
        });
    }

    private function getOverviewData()
    {
        $propertyIds = $this->getHostPropertyIds();
        
        $stats = [
            'Report Period' => $this->startDate->format('Y-m-d') . ' to ' . $this->endDate->format('Y-m-d'),
            'Total Properties' => $propertyIds->count(),
            'Total Bookings' => Booking::whereIn('property_id', $propertyIds)
                ->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->count(),
            'Confirmed Bookings' => Booking::whereIn('property_id', $propertyIds)
                ->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->where('status', 'confirmed')
                ->count(),
            'Total Revenue' => number_format(Booking::whereIn('property_id', $propertyIds)
                ->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->whereIn('status', ['confirmed', 'completed'])
                ->sum('total_amount'), 2),
            'Pending Payouts' => number_format(Booking::whereIn('property_id', $propertyIds)
                ->where('payout_status', 'pending')
                ->sum('total_amount') * 0.8, 2),
            'Average Rating' => number_format(Review::whereIn('property_id', $propertyIds)
                ->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->avg('overall_rating') ?? 0, 1),
            'Cancellation Rate' => $this->calculateCancellationRate($propertyIds) . '%',
            'Occupancy Rate' => $this->calculateOccupancyRate($propertyIds) . '%',
        ];

        return collect([$stats])->map(function ($item) {
            return $item;
        })->values();
    }

    private function calculateCancellationRate($propertyIds)
    {
        $total = Booking::whereIn('property_id', $propertyIds)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();
        if ($total === 0) return 0;
        $cancelled = Booking::whereIn('property_id', $propertyIds)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->where('status', 'cancelled')
            ->count();
        return round(($cancelled / $total) * 100, 2);
    }

    private function calculateOccupancyRate($propertyIds)
    {
        $totalProperties = $propertyIds->count();
        if ($totalProperties === 0) return 0;
        $daysInRange = $this->startDate->diffInDays($this->endDate) + 1;
        $totalPropertyDays = $totalProperties * $daysInRange;
        $occupiedDays = Booking::whereIn('property_id', $propertyIds)
            ->whereBetween('check_in', [$this->startDate, $this->endDate])
            ->orWhereBetween('check_out', [$this->startDate, $this->endDate])
            ->selectRaw('property_id, DATEDIFF(LEAST(check_out, ?), GREATEST(check_in, ?)) as days', [$this->endDate, $this->startDate])
            ->get()
            ->sum('days');
        return round(($occupiedDays / $totalPropertyDays) * 100, 2);
    }

    public function headings(): array
    {
        return match($this->reportType) {
            'bookings' => ['ID', 'Guest', 'Property', 'Check In', 'Check Out', 'Guests', 'Total Amount', 'Status', 'Created'],
            'revenue' => ['Property', 'Location', 'Total Bookings', 'Total Revenue', 'Average per Booking'],
            'reviews' => ['ID', 'Property', 'Guest', 'Overall Rating', 'Cleanliness', 'Communication', 'Location', 'Value', 'Comment', 'Date'],
            'payouts' => ['Booking ID', 'Property', 'Guest', 'Check In', 'Check Out', 'Total Amount', 'Payout Amount', 'Payout Status', 'Date'],
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
