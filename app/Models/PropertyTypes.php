<?php

namespace App\Models;

/**
 * Global Property Types Configuration
 * Based on Section 3.1 of the Requirements Document
 */
class PropertyTypes
{
    /**
     * Main property categories
     */
    public const CATEGORIES = [
        'entire_place' => 'Entire Place',
        'private_room' => 'Private Room',
        'shared_space' => 'Shared Space',
        'boutique_hotel' => 'Boutique Hotel',
        'alternative' => 'Alternative Accommodation',
    ];

    /**
     * Property types with subcategories
     */
    public const TYPES = [
        // Entire Place - House
        'entire_place' => [
            'house' => [
                'name' => 'House',
                'subtypes' => [
                    'detached_house' => 'Detached House',
                    'semi_detached' => 'Semi-Detached',
                    'townhouse' => 'Townhouse',
                    'villa' => 'Villa',
                    'cottage' => 'Cottage',
                    'farmhouse' => 'Farmhouse',
                    'mansion' => 'Mansion',
                    'bungalow' => 'Bungalow',
                    'chalet' => 'Chalet',
                ],
            ],
            'apartment' => [
                'name' => 'Apartment',
                'subtypes' => [
                    'studio' => 'Studio',
                    'loft' => 'Loft',
                    'penthouse' => 'Penthouse',
                    'duplex' => 'Duplex',
                    'condominium' => 'Condominium',
                    'serviced_apartment' => 'Serviced Apartment',
                    'flat' => 'Flat',
                ],
            ],
            'unique_spaces' => [
                'name' => 'Unique Spaces',
                'subtypes' => [
                    'treehouse' => 'Treehouse',
                    'houseboat' => 'Houseboat',
                    'yurt' => 'Yurt',
                    'tipi' => 'Tipi',
                    'cave_house' => 'Cave House',
                    'lighthouse' => 'Lighthouse',
                    'castle' => 'Castle',
                    'barn' => 'Barn',
                    'container_home' => 'Container Home',
                    'earthship' => 'Earthship',
                    'igloo' => 'Igloo',
                    'windmill' => 'Windmill',
                    'dome' => 'Dome',
                    'tiny_house' => 'Tiny House',
                    'boat' => 'Boat',
                    'camper_rv' => 'Camper/RV',
                    'tent' => 'Tent',
                    'glamping' => 'Glamping',
                ],
            ],
        ],
        
        // Private Room
        'private_room' => [
            'single_room' => [
                'name' => 'Single Room',
                'subtypes' => [
                    'single_room' => 'Single Room',
                    'cosy_room' => 'Cosy Room',
                ],
            ],
            'double_room' => [
                'name' => 'Double Room',
                'subtypes' => [
                    'double_room' => 'Double Room',
                    'queen_room' => 'Queen Room',
                    'king_room' => 'King Room',
                    'twin_room' => 'Twin Room',
                ],
            ],
            'ensuite' => [
                'name' => 'En-Suite Room',
                'subtypes' => [
                    'ensuite' => 'En-Suite Room',
                    'private_bathroom' => 'Private Bathroom',
                ],
            ],
            'shared_bathroom' => [
                'name' => 'Shared Bathroom',
                'subtypes' => [
                    'shared_bathroom' => 'Shared Bathroom',
                    'shared_room' => 'Shared Room',
                ],
            ],
            'hostel' => [
                'name' => 'Hostel',
                'subtypes' => [
                    'hostel_bed' => 'Hostel Bed',
                    'dormitory' => 'Dormitory',
                    'mixed_dorm' => 'Mixed Dorm',
                    'female_dorm' => 'Female Dorm',
                    'male_dorm' => 'Male Dorm',
                ],
            ],
        ],
        
        // Shared Space
        'shared_space' => [
            'couch' => [
                'name' => 'Couch',
                'subtypes' => [
                    'couch_surfing' => 'Couch Surfing',
                    'couch' => 'Couch',
                ],
            ],
            'camping' => [
                'name' => 'Camping',
                'subtypes' => [
                    'camping_spot' => 'Camping Spot',
                    'tent_site' => 'Tent Site',
                    'caravan_spot' => 'Caravan Spot',
                ],
            ],
            'hammock' => [
                'name' => 'Hammock',
                'subtypes' => [
                    'hammock_space' => 'Hammock Space',
                ],
            ],
            'common_area' => [
                'name' => 'Common Area',
                'subtypes' => [
                    'living_room' => 'Living Room',
                    'common_space' => 'Common Space',
                ],
            ],
        ],
        
        // Boutique Hotels
        'boutique_hotel' => [
            'design_hotel' => [
                'name' => 'Design Hotel',
                'subtypes' => [
                    'design_hotel' => 'Design Hotel',
                    'boutique_hotel' => 'Boutique Hotel',
                ],
            ],
            'heritage' => [
                'name' => 'Heritage Hotel',
                'subtypes' => [
                    'heritage_hotel' => 'Heritage Hotel',
                    'historic_hotel' => 'Historic Hotel',
                    'palace' => 'Palace',
                ],
            ],
            'eco_lodge' => [
                'name' => 'Eco Lodge',
                'subtypes' => [
                    'eco_lodge' => 'Eco Lodge',
                    'sustainable_lodge' => 'Sustainable Lodge',
                ],
            ],
            'resort' => [
                'name' => 'Resort',
                'subtypes' => [
                    'resort' => 'Resort',
                    'beach_resort' => 'Beach Resort',
                    'ski_resort' => 'Ski Resort',
                    'spa_resort' => 'Spa Resort',
                    'all_inclusive' => 'All-Inclusive Resort',
                ],
            ],
            'ryokan' => [
                'name' => 'Ryokan (Japan)',
                'subtypes' => [
                    'ryokan' => 'Ryokan',
                    'traditional_inn' => 'Traditional Inn',
                ],
            ],
        ],
        
        // Alternative Accommodation
        'alternative' => [
            'university' => [
                'name' => 'University Housing',
                'subtypes' => [
                    'university_dorm' => 'University Dorm',
                    'student_housing' => 'Student Housing',
                    'dormitory_room' => 'Dormitory Room',
                ],
            ],
            'monastery' => [
                'name' => 'Monastery Stay',
                'subtypes' => [
                    'monastery' => 'Monastery',
                    'temple_stay' => 'Temple Stay',
                    'retreat_center' => 'Retreat Center',
                ],
            ],
            'farm_stay' => [
                'name' => 'Farm Stay',
                'subtypes' => [
                    'farm_stay' => 'Farm Stay',
                    'agritourism' => 'Agritourism',
                    'working_farm' => 'Working Farm',
                ],
            ],
            'vineyard' => [
                'name' => 'Vineyard Stay',
                'subtypes' => [
                    'vineyard' => 'Vineyard',
                    'wine_estate' => 'Wine Estate',
                    'winery' => 'Winery',
                ],
            ],
            'artist_studio' => [
                'name' => 'Artist Studio',
                'subtypes' => [
                    'artist_studio' => 'Artist Studio',
                    'creative_space' => 'Creative Space',
                ],
            ],
            'wellness' => [
                'name' => 'Wellness Center',
                'subtypes' => [
                    'wellness_center' => 'Wellness Center',
                    'health_retreat' => 'Health Retreat',
                    'yoga_retreat' => 'Yoga Retreat',
                ],
            ],
        ],
    ];

    /**
     * Specialized categories for filtering
     */
    public const SPECIALIZED_CATEGORIES = [
        'work_friendly' => [
            'name' => 'Work-Friendly',
            'icon' => 'briefcase',
            'features' => [
                'dedicated_workspace',
                'ergonomic_chair',
                'high_speed_wifi',
                'printer_access',
                'quiet_hours',
                'video_call_friendly',
                'monitor_available',
            ],
        ],
        'digital_nomad' => [
            'name' => 'Digital Nomad Certified',
            'icon' => 'laptop',
            'features' => [
                'internet_speed_50mbps',
                'backup_internet',
                '24_7_workspace_access',
                'extended_stay_discounts',
                'international_plugs',
                'webcam_friendly',
            ],
        ],
        'accessible' => [
            'name' => 'Accessibility Certified',
            'icon' => 'wheelchair',
            'features' => [
                'wheelchair_accessible',
                'step_free_access',
                'wide_doorways',
                'roll_in_shower',
                'grab_rails',
                'visual_alarms',
                'service_animal_allowed',
            ],
        ],
        'eco_certified' => [
            'name' => 'Eco-Certified',
            'icon' => 'leaf',
            'features' => [
                'solar_powered',
                'rainwater_harvesting',
                'composting_toilet',
                'organic_garden',
                'zero_waste_policy',
                'energy_efficient',
                'ev_charger',
            ],
        ],
        'family_friendly' => [
            'name' => 'Family-Friendly',
            'icon' => 'users',
            'features' => [
                'crib_available',
                'high_chair',
                'baby_bath',
                'kids_books',
                'toys',
                'stair_gate',
                'childproofed',
            ],
        ],
        'pet_friendly' => [
            'name' => 'Pet-Friendly',
            'icon' => 'paw',
            'features' => [
                'pet_beds',
                'pet_toys',
                'fenced_yard',
                'pet_gate',
                'nearby_park',
                'pet_sitting',
            ],
        ],
        'romantic' => [
            'name' => 'Romantic',
            'icon' => 'heart',
            'features' => [
                'hot_tub',
                'fireplace',
                'scenic_view',
                'private_balcony',
                'couples_massage',
            ],
        ],
        'luxury' => [
            'name' => 'Luxury',
            'icon' => 'star',
            'features' => [
                'private_pool',
                'butler_service',
                'gym',
                'spa',
                'chef',
                'concierge',
            ],
        ],
    ];

    /**
     * Amenity categories
     */
    public const AMENITY_CATEGORIES = [
        'essential' => [
            'name' => 'Essentials',
            'icon' => 'home',
            'items' => [
                'wifi', 'heating', 'ac', 'towels', 'bed_sheets', 
                'soap', 'toilet_paper', 'pillows', 'drinking_water',
            ],
        ],
        'safety' => [
            'name' => 'Safety',
            'icon' => 'shield',
            'items' => [
                'smoke_detector', 'carbon_monoxide', 'first_aid_kit',
                'fire_extinguisher', 'emergency_exit', 'lock_on_door',
            ],
        ],
        'bathroom' => [
            'name' => 'Bathroom',
            'icon' => 'droplet',
            'items' => [
                'hair_dryer', 'shampoo', 'conditioner', 'body_wash',
                'hot_water', 'bath_tub', 'bidet', 'bathrobe', 'slippers',
            ],
        ],
        'kitchen' => [
            'name' => 'Kitchen',
            'icon' => 'utensils',
            'items' => [
                'refrigerator', 'microwave', 'oven', 'stove', 'dishwasher',
                'coffee_maker', 'kettle', 'toaster', 'blender', 'cookware',
                'dishes', 'wine_glasses', 'trash_can',
            ],
        ],
        'bedroom' => [
            'name' => 'Bedroom',
            'icon' => 'bed',
            'items' => [
                'bed_linens', 'extra_pillows', 'extra_blankets', 'blackout_curtains',
                'alarm_clock', 'closet', 'hangers', 'safe', 'iron',
            ],
        ],
        'entertainment' => [
            'name' => 'Entertainment',
            'icon' => 'tv',
            'items' => [
                'tv', 'streaming_services', 'cable', 'sound_system',
                'board_games', 'books', 'kids_toys', 'video_games',
            ],
        ],
        'outdoor' => [
            'name' => 'Outdoor',
            'icon' => 'sun',
            'items' => [
                'private_patio', 'shared_patio', 'garden', 'bbq',
                'outdoor_furniture', 'fire_pit', 'pool', 'hot_tub', 'beach_access',
            ],
        ],
        'work' => [
            'name' => 'Work',
            'icon' => 'briefcase',
            'items' => [
                'workspace', 'desk', 'ergonomic_chair', 'monitor',
                'printer', 'fast_wifi', 'ethernet', 'webcam',
            ],
        ],
        'family' => [
            'name' => 'Family',
            'icon' => 'users',
            'items' => [
                'crib', 'high_chair', 'baby_bath', 'baby_monitor',
                'kids_books', 'toys', 'stair_gate', 'outlet_covers',
            ],
        ],
        'parking' => [
            'name' => 'Parking',
            'icon' => 'car',
            'items' => [
                'free_parking', 'paid_parking', 'garage', 'street_parking',
                'ev_charger', 'accessible_parking',
            ],
        ],
        'view' => [
            'name' => 'View',
            'icon' => 'eye',
            'items' => [
                'sea_view', 'mountain_view', 'city_view', 'lake_view',
                'garden_view', 'pool_view', 'river_view',
            ],
        ],
    ];

    /**
     * Get all amenity items flattened
     */
    public static function getAllAmenities(): array
    {
        $amenities = [];
        foreach (self::AMENITY_CATEGORIES as $category => $data) {
            $amenities = array_merge($amenities, $data['items']);
        }
        return $amenities;
    }

    /**
     * Get all property types flattened
     */
    public static function getAllPropertyTypes(): array
    {
        $types = [];
        foreach (self::TYPES as $category => $categoryData) {
            foreach ($categoryData as $type => $typeData) {
                $types[$type] = $typeData['name'];
                if (isset($typeData['subtypes'])) {
                    foreach ($typeData['subtypes'] as $subtype => $subtypeName) {
                        $types[$subtype] = $subtypeName;
                    }
                }
            }
        }
        return $types;
    }

    /**
     * Cancellation policies
     */
    public const CANCELLATION_POLICIES = [
        'flexible' => [
            'name' => 'Flexible',
            'description' => 'Full refund up to 24 hours before check-in',
            'refund_before' => 24, // hours
            'refund_percentage' => 100,
        ],
        'moderate' => [
            'name' => 'Moderate',
            'description' => 'Full refund up to 5 days before check-in',
            'refund_before' => 120, // hours
            'refund_percentage' => 100,
        ],
        'strict' => [
            'name' => 'Strict',
            'description' => '50% refund up to 7 days before check-in',
            'refund_before' => 168, // hours
            'refund_percentage' => 50,
        ],
        'super_strict' => [
            'name' => 'Super Strict',
            'description' => '50% refund up to 30 days before check-in',
            'refund_before' => 720, // hours
            'refund_percentage' => 50,
        ],
        'long_term' => [
            'name' => 'Long-term',
            'description' => 'First month non-refundable',
            'refund_before' => 720, // hours
            'refund_percentage' => 0,
            'min_nights' => 28,
        ],
    ];
}
