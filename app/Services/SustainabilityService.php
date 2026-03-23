<?php

namespace App\Services;

use App\Models\User;
use App\Models\Property;

class SustainabilityService
{
    /**
     * Calculate sustainability score for a host/property
     */
    public static function calculateScore($hostId, $propertyId = null)
    {
        $host = User::find($hostId);
        $score = 0;
        $components = [];

        // Energy Efficiency (0-25 points)
        $energy = self::calculateEnergyScore($propertyId);
        $score += $energy['points'];
        $components['energy'] = $energy;

        // Water Conservation (0-20 points)
        $water = self::calculateWaterScore($propertyId);
        $score += $water['points'];
        $components['water'] = $water;

        // Waste Management (0-20 points)
        $waste = self::calculateWasteScore($propertyId);
        $score += $waste['points'];
        $components['waste'] = $waste;

        // Transportation (0-15 points)
        $transport = self::calculateTransportScore($hostId, $propertyId);
        $score += $transport['points'];
        $components['transport'] = $transport;

        // Community Impact (0-15 points)
        $community = self::calculateCommunityScore($hostId);
        $score += $community['points'];
        $components['community'] = $community;

        // Carbon Offset (0-5 points)
        $carbon = self::calculateCarbonOffsetScore($hostId);
        $score += $carbon['points'];
        $components['carbon'] = $carbon;

        // Update user if property is null (overall score)
        if ($propertyId === null && $host) {
            $host->update([
                'sustainability_score' => round($score),
                'sustainability_details' => $components,
            ]);
        }

        return [
            'total' => round($score),
            'components' => $components,
            'level' => self::getScoreLevel($score),
            'recommendations' => self::getRecommendations($components),
        ];
    }

    /**
     * Calculate energy efficiency score
     */
    public static function calculateEnergyScore($propertyId)
    {
        $property = Property::find($propertyId);
        $points = 0;
        $details = [];

        if ($property) {
            // Renewable energy sources
            if ($property->has_solar_panels) {
                $points += 8;
                $details[] = 'Solar panels installed';
            }

            if ($property->has_wind_power) {
                $points += 5;
                $details[] = 'Wind power available';
            }

            // Energy-efficient appliances
            if ($property->energy_star_appliances) {
                $points += 5;
                $details[] = 'ENERGY STAR certified appliances';
            }

            // LED lighting
            if ($property->led_lighting_percentage >= 80) {
                $points += 4;
                $details[] = '80%+ LED lighting';
            } elseif ($property->led_lighting_percentage >= 50) {
                $points += 2;
                $details[] = '50%+ LED lighting';
            }

            // Smart thermostat
            if ($property->smart_thermostat) {
                $points += 3;
                $details[] = 'Smart thermostat installed';
            }
        }

        return ['points' => min($points, 25), 'details' => $details];
    }

    /**
     * Calculate water conservation score
     */
    public static function calculateWaterScore($propertyId)
    {
        $property = Property::find($propertyId);
        $points = 0;
        $details = [];

        if ($property) {
            // Water-efficient fixtures
            if ($property->low_flow_showers) {
                $points += 6;
                $details[] = 'Low-flow shower heads';
            }

            if ($property->low_flow_toilets) {
                $points += 6;
                $details[] = 'Low-flow toilets';
            }

            // Rainwater harvesting
            if ($property->rainwater_harvesting) {
                $points += 5;
                $details[] = 'Rainwater harvesting system';
            }

            // Drought-resistant landscaping
            if ($property->native_plants_landscaping) {
                $points += 3;
                $details[] = 'Native plants landscaping';
            }
        }

        return ['points' => min($points, 20), 'details' => $details];
    }

    /**
     * Calculate waste management score
     */
    public static function calculateWasteScore($propertyId)
    {
        $property = Property::find($propertyId);
        $points = 0;
        $details = [];

        if ($property) {
            // Recycling program
            if ($property->recycling_available) {
                $points += 7;
                $details[] = 'Recycling program available';
            }

            // Composting
            if ($property->composting_available) {
                $points += 6;
                $details[] = 'Composting available';
            }

            // Single-use plastic ban
            if ($property->no_single_use_plastics) {
                $points += 4;
                $details[] = 'Single-use plastics banned';
            }

            // Eco-friendly toiletries
            if ($property->eco_toiletries_only) {
                $points += 3;
                $details[] = 'Eco-friendly toiletries only';
            }
        }

        return ['points' => min($points, 20), 'details' => $details];
    }

    /**
     * Calculate transportation impact score
     */
    public static function calculateTransportScore($hostId, $propertyId)
    {
        $property = Property::find($propertyId);
        $points = 0;
        $details = [];

        if ($property) {
            // Public transit accessibility
            $transitScore = $property->transit_score ?? 0;
            if ($transitScore >= 90) {
                $points += 6;
                $details[] = 'Excellent public transit access';
            } elseif ($transitScore >= 70) {
                $points += 4;
                $details[] = 'Good public transit access';
            } elseif ($transitScore >= 50) {
                $points += 2;
                $details[] = 'Some public transit access';
            }

            // EV charging
            if ($property->ev_charging_available) {
                $points += 5;
                $details[] = 'EV charging available';
            }

            // Bike parking
            if ($property->bike_parking_available) {
                $points += 2;
                $details[] = 'Bike parking available';
            }

            // Walking distance amenities
            if ($property->walkable_score >= 80) {
                $points += 2;
                $details[] = 'Highly walkable neighborhood';
            }
        }

        return ['points' => min($points, 15), 'details' => $details];
    }

    /**
     * Calculate community impact score
     */
    public static function calculateCommunityScore($hostId)
    {
        $host = User::find($hostId);
        $points = 0;
        $details = [];

        if ($host) {
            // Employs local staff
            if ($host->local_staff_count > 0) {
                $points += 5;
                $details[] = "Employs {$host->local_staff_count} local staff";
            }

            // Sources local products
            if ($host->sources_local_products) {
                $points += 4;
                $details[] = 'Sources local products';
            }

            // Community involvement
            if ($host->community_involvement > 0) {
                $points += 3;
                $details[] = 'Active community involvement';
            }

            // Local business partnerships
            if ($host->local_partnerships > 0) {
                $points += 3;
                $details[] = "Partnerships with {$host->local_partnerships} local businesses";
            }
        }

        return ['points' => min($points, 15), 'details' => $details];
    }

    /**
     * Calculate carbon offset score
     */
    public static function calculateCarbonOffsetScore($hostId)
    {
        $host = User::find($hostId);
        $points = 0;
        $details = [];

        if ($host) {
            // Carbon neutral certification
            if ($host->carbon_neutral_certified) {
                $points += 3;
                $details[] = 'Carbon neutral certified';
            }

            // Tree planting initiatives
            if ($host->trees_planted > 0) {
                $points += 2;
                $details[] = "Planted {$host->trees_planted} trees";
            }
        }

        return ['points' => min($points, 5), 'details' => $details];
    }

    /**
     * Get sustainability level based on score
     */
    public static function getScoreLevel($score)
    {
        if ($score >= 90) return 'Platinum';
        if ($score >= 75) return 'Gold';
        if ($score >= 60) return 'Silver';
        if ($score >= 45) return 'Bronze';
        return 'Developing';
    }

    /**
     * Get recommendations based on current score
     */
    public static function getRecommendations($components)
    {
        $recommendations = [];

        // Energy recommendations
        if ($components['energy']['points'] < 15) {
            $recommendations[] = 'Consider installing solar panels or LED lighting';
        }

        // Water recommendations
        if ($components['water']['points'] < 10) {
            $recommendations[] = 'Upgrade to low-flow water fixtures';
        }

        // Waste recommendations
        if ($components['waste']['points'] < 10) {
            $recommendations[] = 'Implement recycling and composting programs';
        }

        // Transport recommendations
        if ($components['transport']['points'] < 10) {
            $recommendations[] = 'Install EV charging or improve bike facilities';
        }

        // Community recommendations
        if ($components['community']['points'] < 10) {
            $recommendations[] = 'Partner with local businesses and hire local staff';
        }

        return $recommendations;
    }
}
