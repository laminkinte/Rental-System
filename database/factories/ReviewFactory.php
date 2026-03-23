<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'reviewer_id' => User::factory(),
            'reviewee_id' => User::factory(),
            'type' => fake()->randomElement(['guest_to_host', 'host_to_guest']),
            'overall_rating' => fake()->numberBetween(3, 5),
            'comment' => fake()->paragraph(2),
            'ratings' => [
                'cleanliness' => fake()->numberBetween(3, 5),
                'communication' => fake()->numberBetween(3, 5),
                'location' => fake()->numberBetween(3, 5),
                'value' => fake()->numberBetween(3, 5),
            ],
            'photos' => null,
            'is_public' => true,
        ];
    }

    public function hostToGuest(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'host_to_guest',
            'overall_rating' => fake()->numberBetween(3, 5),
            'comment' => fake()->sentence(),
        ]);
    }
}
