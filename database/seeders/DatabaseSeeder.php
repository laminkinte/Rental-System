<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Wallet;
use App\Models\SiteSetting;
use App\Models\Notification;
use App\Models\Message;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Seeding database...');
        $this->command->info('');

        // 0. Seed Roles and Permissions (must run first)
        $this->call(RolesAndPermissionsSeeder::class);
        $this->command->info('✅ Created roles and permissions');

        // 1. Seed Users (Admin, Hosts, Guests)
        $this->call(UserSeeder::class);
        
        // 2. Seed Properties
        $this->call(PropertySeeder::class);

        // 3. Create Bookings
        $allUsers = User::all();
        $allProperties = Property::where('is_active', true)->get();

        if ($allProperties->isNotEmpty()) {
            // Past completed bookings
            Booking::factory()->count(20)->past()->create([
                'user_id' => $allUsers->random()->id,
                'property_id' => $allProperties->random()->id,
            ]);

            // Upcoming confirmed bookings
            Booking::factory()->count(15)->upcoming()->create([
                'user_id' => $allUsers->random()->id,
                'property_id' => $allProperties->random()->id,
            ]);

            // Pending bookings
            Booking::factory()->count(5)->pending()->create([
                'user_id' => $allUsers->random()->id,
                'property_id' => $allProperties->random()->id,
            ]);

            // Cancelled bookings
            Booking::factory()->count(3)->cancelled()->create([
                'user_id' => $allUsers->random()->id,
                'property_id' => $allProperties->random()->id,
            ]);

            $this->command->info('✅ Created bookings (past, upcoming, pending, cancelled)');
        }

        // 4. Create Reviews for completed bookings
        $completedBookings = Booking::where('status', 'completed')->get();
        foreach ($completedBookings as $booking) {
            Review::factory()->create([
                'booking_id' => $booking->id,
                'reviewer_id' => $booking->user_id,
                'reviewee_id' => $booking->property->host_id,
                'type' => 'guest_to_host',
                'overall_rating' => rand(3, 5),
                'comment' => fake()->paragraph(2),
                'ratings' => [
                    'cleanliness' => rand(3, 5),
                    'communication' => rand(3, 5),
                    'location' => rand(3, 5),
                    'value' => rand(3, 5),
                ],
                'is_public' => true,
            ]);
        }
        $this->command->info('✅ Created reviews for completed bookings');

        // 5. Create Notifications
        foreach ($allUsers->random(10) as $user) {
            Notification::factory()->count(rand(1, 5))->create([
                'user_id' => $user->id,
            ]);
        }
        $this->command->info('✅ Created notifications');

        // 6. Create Messages
        $bookingWithGuest = Booking::where('status', 'confirmed')->first();
        if ($bookingWithGuest) {
            Message::updateOrCreate(
                [
                    'sender_id' => $bookingWithGuest->user_id,
                    'receiver_id' => $bookingWithGuest->property->host_id,
                    'booking_id' => $bookingWithGuest->id
                ],
                [
                    'subject' => 'Booking Inquiry',
                    'message' => 'Hi! I am excited to stay at your property. Do you have any recommendations for local restaurants?',
                    'is_read' => false,
                ]
            );

            Message::updateOrCreate(
                [
                    'sender_id' => $bookingWithGuest->property->host_id,
                    'receiver_id' => $bookingWithGuest->user_id,
                    'booking_id' => $bookingWithGuest->id
                ],
                [
                    'subject' => 'Re: Booking Inquiry',
                    'message' => 'Welcome! Yes, I highly recommend The Beach House and Kunta Kinte. Let me know if you need more suggestions!',
                    'is_read' => false,
                ]
            );
        }
        $this->command->info('✅ Created sample messages');

        // 7. Create Site Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'JubbaStay'],
            ['key' => 'tagline', 'value' => 'Connect & Stay - Discover The Gambia'],
            ['key' => 'site_description', 'value' => 'Your trusted accommodation platform in The Gambia. Find unique stays and authentic experiences.'],
            ['key' => 'contact_email', 'value' => 'hello@jubbastay.com'],
            ['key' => 'contact_phone', 'value' => '+220 123 4567'],
            ['key' => 'address', 'value' => 'Banjul, The Gambia'],
            ['key' => 'logo_url', 'value' => '/logo.png'],
            ['key' => 'commission_rate', 'value' => '10'],
            ['key' => 'minimum_payout', 'value' => '50'],
            ['key' => 'currency', 'value' => 'USD'],
            ['key' => 'supported_languages', 'value' => json_encode(['en', 'fr', 'de'])],
            ['key' => 'guest_service_fee_percent', 'value' => '12'],
            ['key' => 'host_service_fee_percent', 'value' => '15'],
            ['key' => 'allow_instant_book', 'value' => 'true'],
            ['key' => 'require_verification', 'value' => 'true'],
            ['key' => 'maintenance_mode', 'value' => 'false'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
        $this->command->info('✅ Created site settings');

        $this->command->info('');
        $this->command->info('🎉 Database seeding completed!');
    }
}
