<?php

namespace App\Services;

use App\Models\Property;
use App\Models\DynamicPrice;
use App\Models\Booking;
use Carbon\Carbon;

class DynamicPricingService
{
    /**
     * Calculate dynamic price for a property on a specific date
     */
    public static function calculatePrice(Property $property, Carbon $date)
    {
        // Check if custom price exists
        $customPrice = DynamicPrice::where('property_id', $property->id)
            ->where('date', $date->format('Y-m-d'))
            ->first();

        if ($customPrice && $customPrice->dynamic_price) {
            return $customPrice->dynamic_price;
        }

        $basePrice = $property->base_price;
        $factors = self::calculatePriceFactors($property, $date);

        $dynamicPrice = $basePrice;

        // Apply occupancy factor
        if (isset($factors['occupancy_factor'])) {
            $dynamicPrice *= $factors['occupancy_factor'];
        }

        // Apply seasonal factor
        if (isset($factors['seasonal_factor'])) {
            $dynamicPrice *= $factors['seasonal_factor'];
        }

        // Apply day of week factor
        if (isset($factors['day_factor'])) {
            $dynamicPrice *= $factors['day_factor'];
        }

        // Apply event factor
        if (isset($factors['event_factor'])) {
            $dynamicPrice *= $factors['event_factor'];
        }

        // Apply holiday factor
        if (isset($factors['holiday_factor'])) {
            $dynamicPrice *= $factors['holiday_factor'];
        }

        // Apply competitor factor
        if (isset($factors['competitor_factor'])) {
            $dynamicPrice *= $factors['competitor_factor'];
        }

        // Store the calculated price
        DynamicPrice::updateOrCreate(
            [
                'property_id' => $property->id,
                'date' => $date->format('Y-m-d'),
            ],
            [
                'base_price' => $basePrice,
                'dynamic_price' => round($dynamicPrice, 2),
                'reason' => 'algorithmic',
                'factors' => $factors,
                'occupancy_rate' => $factors['occupancy_rate'] ?? 0,
                'is_active' => true,
            ]
        );

        return round($dynamicPrice, 2);
    }

    /**
     * Calculate all price adjustment factors
     */
    public static function calculatePriceFactors(Property $property, Carbon $date)
    {
        $factors = [];

        // Occupancy Rate Factor (0.7 - 1.5x)
        $occupancyRate = self::calculateOccupancyRate($property, $date);
        $factors['occupancy_rate'] = $occupancyRate;
        $factors['occupancy_factor'] = self::getOccupancyFactor($occupancyRate);

        // Seasonal Factor (0.8 - 1.3x)
        $factors['seasonal_factor'] = self::getSeasonalFactor($date);

        // Day of Week Factor (0.85 - 1.2x)
        $factors['day_factor'] = self::getDayOfWeekFactor($date);

        // Event Factor (1.0 - 2.0x)
        $factors['event_factor'] = self::getEventFactor($property->city, $date);

        // Holiday Factor (0.9 - 1.5x)
        $factors['holiday_factor'] = self::getHolidayFactor($date);

        // Competitor Factor (0.95 - 1.05x)
        $factors['competitor_factor'] = self::getCompetitorFactor($property);

        // Booking lead time factor
        $daysUntil = now()->diffInDays($date);
        $factors['lead_time_factor'] = self::getLeadTimeFactor($daysUntil);

        return $factors;
    }

    /**
     * Calculate occupancy rate for the area on that date
     */
    public static function calculateOccupancyRate(Property $property, Carbon $date)
    {
        $totalProperties = Property::where('city', $property->city)->count();
        $bookedProperties = Booking::where('check_in', '<=', $date)
            ->where('check_out', '>', $date)
            ->whereHas('property', fn($q) => $q->where('city', $property->city))
            ->count();

        return $totalProperties > 0 ? $bookedProperties / $totalProperties : 0;
    }

    /**
     * Get occupancy-based price multiplier
     * High occupancy = higher prices
     */
    public static function getOccupancyFactor($occupancyRate)
    {
        if ($occupancyRate < 0.3) return 0.7;  // Low occupancy, discount
        if ($occupancyRate < 0.5) return 0.85;
        if ($occupancyRate < 0.7) return 1.0;
        if ($occupancyRate < 0.85) return 1.15;
        return 1.5; // Very high occupancy, premium
    }

    /**
     * Get seasonal multiplier
     */
    public static function getSeasonalFactor(Carbon $date)
    {
        $month = $date->month;

        // December-January: High season (holidays)
        if (in_array($month, [12, 1])) return 1.3;

        // July-August: Summer vacation
        if (in_array($month, [7, 8])) return 1.2;

        // April-May, September-October: Shoulder season
        if (in_array($month, [4, 5, 9, 10])) return 1.05;

        // February-March, November: Low season
        return 0.8;
    }

    /**
     * Get day of week multiplier
     * Weekends are more expensive than weekdays
     */
    public static function getDayOfWeekFactor(Carbon $date)
    {
        $dayOfWeek = $date->dayOfWeek;

        if (in_array($dayOfWeek, [5, 6])) { // Friday, Saturday
            return 1.2;
        } elseif ($dayOfWeek === 0) { // Sunday
            return 1.1;
        }

        return 0.95; // Weekday discount
    }

    /**
     * Get event-based price multiplier
     */
    public static function getEventFactor($city, Carbon $date)
    {
        // TODO: Integrate with events API or database
        // For now, return default
        $events = [
            'Banjul' => [
                '12-25' => 1.5, // Christmas
                '01-01' => 1.4, // New Year
                '02-18' => 1.2, // Independence Day
            ],
            'Serrekunda' => [
                '12-25' => 1.4,
                '01-01' => 1.3,
            ],
        ];

        $dateKey = $date->format('m-d');
        return $events[$city][$dateKey] ?? 1.0;
    }

    /**
     * Get holiday multiplier
     */
    public static function getHolidayFactor(Carbon $date)
    {
        $holidays = [
            '01-01', // New Year
            '02-18', // Independence Day
            '04-22', // Earth Day
            '05-01', // Labour Day
            '12-25', // Christmas
        ];

        if (in_array($date->format('m-d'), $holidays)) {
            return 1.4;
        }

        // Days before/after holidays
        $beforeHoliday = $date->copy()->addDay()->format('m-d');
        $afterHoliday = $date->copy()->subDay()->format('m-d');

        if (in_array($beforeHoliday, $holidays) || in_array($afterHoliday, $holidays)) {
            return 1.2;
        }

        return 1.0;
    }

    /**
     * Get competitor-based price adjustment
     */
    public static function getCompetitorFactor(Property $property)
    {
        // TODO: Integrate with competitor intelligence service
        // For now, return neutral factor
        return 1.0;
    }

    /**
     * Get lead time based multiplier
     * Last-minute bookings can be discounted or premium
     */
    public static function getLeadTimeFactor($daysUntil)
    {
        if ($daysUntil < 3) return 0.9;  // Last-minute discount
        if ($daysUntil < 7) return 0.95;
        if ($daysUntil < 14) return 1.0;
        if ($daysUntil < 30) return 1.02;

        return 1.05; // Early bookings slightly premium
    }

    /**
     * Set custom prices manually (for hosts)
     */
    public static function setCustomPrice(Property $property, Carbon $date, $price, $reason = 'manual')
    {
        DynamicPrice::updateOrCreate(
            [
                'property_id' => $property->id,
                'date' => $date->format('Y-m-d'),
            ],
            [
                'base_price' => $property->base_price,
                'dynamic_price' => $price,
                'reason' => $reason,
                'is_active' => true,
            ]
        );
    }

    /**
     * Get price range for a date span
     */
    public static function getPriceRange(Property $property, Carbon $startDate, Carbon $endDate)
    {
        $prices = [];
        $current = $startDate->copy();

        while ($current <= $endDate) {
            $prices[] = self::calculatePrice($property, $current);
            $current->addDay();
        }

        return [
            'min' => min($prices),
            'max' => max($prices),
            'avg' => array_sum($prices) / count($prices),
            'total' => array_sum($prices),
        ];
    }
}
