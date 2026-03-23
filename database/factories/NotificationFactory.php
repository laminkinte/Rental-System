<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        $types = [
            'booking_created',
            'booking_confirmed',
            'booking_cancelled',
            'booking_completed',
            'payment_received',
            'payout_processed',
            'review_received',
            'message_received',
            'verification_approved',
            'property_approved',
        ];

        $titles = [
            'booking_created' => 'New Booking Request',
            'booking_confirmed' => 'Booking Confirmed!',
            'booking_cancelled' => 'Booking Cancelled',
            'booking_completed' => 'Stay Completed',
            'payment_received' => 'Payment Received',
            'payout_processed' => 'Payout Processed',
            'review_received' => 'New Review',
            'message_received' => 'New Message',
            'verification_approved' => 'Verification Approved',
            'property_approved' => 'Property Approved',
        ];

        $type = fake()->randomElement($types);

        return [
            'user_id' => null,
            'type' => $type,
            'title' => $titles[$type],
            'message' => fake()->sentence(),
            'data' => json_encode([
                'booking_id' => fake()->numberBetween(1, 100),
                'property_id' => fake()->numberBetween(1, 50),
            ]),
            'is_read' => fake()->boolean(30),
            'read_at' => fake()->optional()->dateTime(),
        ];
    }

    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_read' => true,
            'read_at' => now(),
        ]);
    }
}
