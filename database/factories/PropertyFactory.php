<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $gambiaCities = [
            'Banjul', 'Serekunda', 'Brikama', 'Bakau', 'Fajikunda',
            'Gunjur', 'Sanyang', 'Kotu', 'Kololi', 'Cape Point',
            'Jinack', 'Marakissa', 'Kartong', 'Brufut', 'Tanji'
        ];
        
        $categories = [
            'beachfront_villa', 'island_resort', 'eco_lodge', 'cultural_homestay',
            'urban_apartment', 'traditional_compound', 'boutique_hotel', 
            'guest_house', 'camping_site', 'river_lodge'
        ];
        
        $titles = [
            'Beachfront Paradise Villa',
            'Cozy Eco Lodge Retreat',
            'Modern City Apartment',
            'Traditional Gambian Homestay',
            'Luxury Island Resort',
            'Seaside Guest House',
            'River Lodge Cabin',
            'Garden View Compound',
            'Boutique Beach Hotel',
            'Family Friendly Apartment',
            'Ocean View Villa',
            'Bush Camp Experience',
            'Urban Studio Flat',
            'Cultural Heritage House',
            'Sunset Beach Resort',
        ];
        
        $descriptions = [
            'Experience the beauty of The Gambia in this stunning property. Wake up to stunning views and enjoy our world-class amenities.',
            'A peaceful retreat surrounded by nature. Perfect for families and couples looking for a relaxing getaway.',
            'Modern accommodation in the heart of the city. Walking distance to restaurants, shops, and beaches.',
            'Immerse yourself in authentic Gambian culture. Our friendly hosts will make you feel at home.',
            'Luxury meets comfort in this beautiful resort. Enjoy private beach access and premium facilities.',
        ];

        return [
            'host_id' => User::factory()->host(),
            'title' => fake()->randomElement($titles),
            'description' => fake()->randomElement($descriptions) . ' ' . fake()->paragraph(2),
            'property_type' => fake()->randomElement(['apartment', 'house', 'villa', 'cottage', 'studio', 'bungalow']),
            'gambia_category' => fake()->randomElement($categories),
            'address' => fake()->streetAddress(),
            'city' => fake()->randomElement($gambiaCities),
            'state' => fake()->randomElement(['Banjul', 'West Coast', 'North Bank', 'Lower River']),
            'country' => 'Gambia',
            'latitude' => 13.4 + (fake()->randomFloat(4, -0.2, 0.2)),
            'longitude' => -15.6 + (fake()->randomFloat(4, -0.2, 0.2)),
            'zip_code' => fake()->postcode(),
            'guest_capacity' => fake()->numberBetween(1, 12),
            'bedrooms' => fake()->numberBetween(1, 6),
            'beds' => fake()->numberBetween(1, 8),
            'bathrooms' => fake()->numberBetween(1, 4),
            'base_price' => fake()->numberBetween(30, 500),
            'weekly_discount' => fake()->numberBetween(0, 20),
            'monthly_discount' => fake()->numberBetween(0, 30),
            'cleaning_fee' => fake()->numberBetween(10, 50),
            'extra_guest_fee' => fake()->numberBetween(10, 30),
            'security_deposit' => fake()->numberBetween(50, 200),
            
            // Amenities
            'running_water' => fake()->boolean(90),
            'electricity' => fake()->boolean(95),
            'wifi' => fake()->boolean(80),
            'air_conditioning' => fake()->boolean(70),
            'kitchen_access' => fake()->boolean(85),
            'parking' => fake()->boolean(80),
            'pool' => fake()->boolean(30),
            'terrace' => fake()->boolean(60),
            'garden' => fake()->boolean(70),
            'security_guard' => fake()->boolean(50),
            'cctv' => fake()->boolean(40),
            'hot_tub' => fake()->boolean(20),
            'bbq' => fake()->boolean(40),
            'beach_access' => fake()->boolean(50),
            'sea_view' => fake()->boolean(60),
            
            // Availability
            'min_nights' => fake()->numberBetween(1, 7),
            'max_nights' => fake()->numberBetween(30, 365),
            'instant_book' => fake()->boolean(60),
            'self_check_in' => fake()->boolean(70),
            
            // Status
            'is_active' => true,
            'verified_listing' => fake()->boolean(70),
            'quality_score' => fake()->randomFloat(1, 3.5, 5.0),
            
            // House rules
            'house_rules' => 'No smoking inside. No parties. Quiet hours after 10 PM.',
            'cancellation_policy' => fake()->randomElement(['flexible', 'moderate', 'strict']),
            'check_in_time' => '15:00',
            'check_out_time' => '11:00',
        ];
    }

    public function beachfront(): static
    {
        return $this->state(fn (array $attributes) => [
            'gambia_category' => 'beachfront_villa',
            'beach_access' => true,
            'sea_view' => true,
            'base_price' => fake()->numberBetween(100, 500),
        ]);
    }

    public function eco(): static
    {
        return $this->state(fn (array $attributes) => [
            'gambia_category' => 'eco_lodge',
            'base_price' => fake()->numberBetween(50, 150),
        ]);
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verified_listing' => true,
            'quality_score' => fake()->randomFloat(1, 4.0, 5.0),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
