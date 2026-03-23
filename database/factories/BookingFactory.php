<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $checkIn = Carbon::now()->addDays(fake()->numberBetween(1, 30));
        $nights = fake()->numberBetween(1, 14);
        $checkOut = $checkIn->copy()->addDays($nights);
        
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
        $status = fake()->randomElement($statuses);
        
        return [
            'user_id' => User::class,
            'property_id' => Property::class,
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'guests' => fake()->numberBetween(1, 6),
            'adults' => fake()->numberBetween(1, 4),
            'children' => fake()->numberBetween(0, 2),
            'infants' => fake()->numberBetween(0, 1),
            'nights' => $nights,
            'subtotal' => fake()->numberBetween(100, 2000),
            'cleaning_fee' => fake()->numberBetween(10, 50),
            'service_fee' => fake()->numberBetween(10, 100),
            'taxes' => fake()->numberBetween(5, 50),
            'total_amount' => fake()->numberBetween(150, 2500),
            'status' => $status,
            'payment_status' => $status === 'confirmed' ? 'paid' : ($status === 'cancelled' ? 'refunded' : 'pending'),
            'payment_method' => fake()->randomElement(['card', 'bank_transfer', 'mobile_money', 'cash']),
            'special_requests' => fake()->optional()->sentence(),
            'guest_name' => fake()->name(),
            'guest_email' => fake()->safeEmail(),
            'guest_phone' => fake()->phoneNumber(),
            'cancelled_at' => $status === 'cancelled' ? now() : null,
            'cancelled_reason' => fake()->optional()->sentence(),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
            'payment_status' => 'paid',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'payment_status' => 'refunded',
            'cancelled_at' => now(),
            'cancelled_reason' => fake()->sentence(),
        ]);
    }

    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'check_in' => Carbon::now()->subDays(fake()->numberBetween(1, 30))->format('Y-m-d'),
            'check_out' => Carbon::now()->subDays(fake()->numberBetween(1, 29))->format('Y-m-d'),
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);
    }

    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'check_in' => Carbon::now()->addDays(fake()->numberBetween(7, 60))->format('Y-m-d'),
            'check_out' => Carbon::now()->addDays(fake()->numberBetween(8, 65))->format('Y-m-d'),
            'status' => 'confirmed',
            'payment_status' => 'paid',
        ]);
    }
}
