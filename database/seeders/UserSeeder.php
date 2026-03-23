<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('👥 Seeding users with detailed information...');

        // 1. Create Admin User
        $admin = User::where('email', 'admin@jubbastay.com')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@jubbastay.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'is_verified' => true,
                'verification_level' => 5,
                'is_host' => false,
                'country' => 'Gambia',
                'phone' => '+220 100 0000',
                'preferred_language' => 'en',
                'preferred_currency' => 'USD',
            ]);
            $this->command->info('✅ Admin user created: admin@jubbastay.com / password');
        } else {
            $this->command->info('ℹ️ Admin user already exists');
        }

        // 2. Create Detailed Host Users
        $hostsData = [
            [
                'name' => 'Musa Jammeh',
                'email' => 'musa.jammeh@jubbastay.com',
                'phone' => '+220 200 1001',
                'country' => 'Gambia',
                'bio' => 'Experienced host with 10+ years in hospitality. Specializing in beachfront properties and eco-lodges across The Gambia.',
                'is_verified' => true,
                'verification_level' => 4,
            ],
            [
                'name' => 'Fatou Smith',
                'email' => 'fatou.smith@jubbastay.com',
                'phone' => '+220 200 1002',
                'country' => 'Gambia',
                'bio' => 'Former hotel manager turned host. Passionate about providing authentic Gambian experiences to travelers.',
                'is_verified' => true,
                'verification_level' => 4,
            ],
            [
                'name' => 'Kemo Balde',
                'email' => 'kemo.balde@jubbastay.com',
                'phone' => '+220 200 1003',
                'country' => 'Gambia',
                'bio' => 'Eco-tourism enthusiast and environmental advocate. My properties focus on sustainable tourism practices.',
                'is_verified' => true,
                'verification_level' => 3,
            ],
            [
                'name' => 'Aminata Williams',
                'email' => 'aminata.williams@jubbastay.com',
                'phone' => '+220 200 1004',
                'country' => 'Gambia',
                'bio' => 'Cultural ambassador offering homestay experiences. Love sharing Gambian traditions with guests.',
                'is_verified' => true,
                'verification_level' => 3,
            ],
            [
                'name' => 'Lamin Cole',
                'email' => 'lamin.cole@jubbastay.com',
                'phone' => '+220 200 1005',
                'country' => 'Gambia',
                'bio' => 'Family man with multiple properties perfect for large groups and family reunions.',
                'is_verified' => true,
                'verification_level' => 4,
            ],
            [
                'name' => 'Isatou Hughes',
                'email' => 'isatou.hughes@jubbastay.com',
                'phone' => '+220 200 1006',
                'country' => 'Gambia',
                'bio' => 'Artisan and boutique hotel owner. My property features local artwork and crafts.',
                'is_verified' => true,
                'verification_level' => 3,
            ],
            [
                'name' => 'Baboucarr Johnson',
                'email' => 'baboucarr.johnson@jubbastay.com',
                'phone' => '+220 200 1007',
                'country' => 'Gambia',
                'bio' => 'Retired fisherman turned host. I offer authentic fishing experiences combined with accommodation.',
                'is_verified' => true,
                'verification_level' => 2,
            ],
            [
                'name' => 'Sira Manneh',
                'email' => 'sira.manneh@jubbastay.com',
                'phone' => '+220 200 1008',
                'country' => 'Gambia',
                'bio' => 'Bird watching guide with properties near prime bird watching locations.',
                'is_verified' => true,
                'verification_level' => 3,
            ],
            [
                'name' => 'Omar Sanneh',
                'email' => 'omar.sanneh@jubbastay.com',
                'phone' => '+220 200 1009',
                'country' => 'Gambia',
                'bio' => 'Island resort specialist. My Jinack Island property offers the ultimate remote escape.',
                'is_verified' => true,
                'verification_level' => 4,
            ],
            [
                'name' => 'Jankey Faye',
                'email' => 'jankey.faye@jubbastay.com',
                'phone' => '+220 200 1010',
                'country' => 'Gambia',
                'bio' => 'Urban apartment specialist. Perfect for business travelers and city explorers.',
                'is_verified' => true,
                'verification_level' => 3,
            ],
            [
                'name' => 'Baba Jammeh',
                'email' => 'baba.jammeh@jubbastay.com',
                'phone' => '+220 200 1011',
                'country' => 'Gambia',
                'bio' => 'Traditional compound host offering immersive cultural experiences.',
                'is_verified' => true,
                'verification_level' => 3,
            ],
            [
                'name' => 'Mariama Singh',
                'email' => 'mariama.singh@jubbastay.com',
                'phone' => '+220 200 1012',
                'country' => 'Gambia',
                'bio' => 'Chef and host offering cooking classes along with accommodation.',
                'is_verified' => true,
                'verification_level' => 2,
            ],
            [
                'name' => 'Edrissa Kinteh',
                'email' => 'edrissa.kinteh@jubbastay.com',
                'phone' => '+220 200 1013',
                'country' => 'Gambia',
                'bio' => 'River lodge owner. Known for excellent bird watching and river cruises.',
                'is_verified' => true,
                'verification_level' => 3,
            ],
            [
                'name' => 'Sulayman Sowe',
                'email' => 'sulayman.sowe@jubbastay.com',
                'phone' => '+220 200 1014',
                'country' => 'Gambia',
                'bio' => 'Family resort owner with properties perfect for group bookings.',
                'is_verified' => true,
                'verification_level' => 3,
            ],
            [
                'name' => 'Yusuf Jarju',
                'email' => 'yusuf.jarju@jubbastay.com',
                'phone' => '+220 200 1015',
                'country' => 'Gambia',
                'bio' => 'New host bringing fresh ideas and modern amenities to the platform.',
                'is_verified' => true,
                'verification_level' => 2,
            ],
        ];

        $createdHosts = 0;
        foreach ($hostsData as $data) {
            $existing = User::where('email', $data['email'])->first();
            if (!$existing) {
                $host = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt('password'),
                    'phone' => $data['phone'],
                    'country' => $data['country'],
                    'bio' => $data['bio'],
                    'role' => 'user',
                    'is_verified' => $data['is_verified'],
                    'verification_level' => $data['verification_level'],
                    'is_host' => true,
                    'host_verified' => $data['verification_level'] >= 3,
                    'superhost' => $data['verification_level'] >= 4,
                    'preferred_language' => 'en',
                    'preferred_currency' => 'USD',
                ]);
                
                // Create wallet for host
                Wallet::create([
                    'user_id' => $host->id,
                    'balance' => rand(100, 5000),
                    'currency' => 'USD',
                    'is_active' => true,
                ]);
                
                $createdHosts++;
            }
        }
        $this->command->info("✅ Created {$createdHosts} host users (email: hostN@jubbastay.com / password)");

        // 3. Create Detailed Guest Users
        $guestsData = [
            ['name' => 'John Mitchell', 'email' => 'john.mitchell@gmail.com', 'country' => 'United Kingdom'],
            ['name' => 'Emma Thompson', 'email' => 'emma.thompson@yahoo.com', 'country' => 'United Kingdom'],
            ['name' => 'Hans Mueller', 'email' => 'hans.mueller@web.de', 'country' => 'Germany'],
            ['name' => 'Sophie Martin', 'email' => 'sophie.martin@gmail.com', 'country' => 'France'],
            ['name' => 'Marco Rossi', 'email' => 'marco.rossi@libero.it', 'country' => 'Italy'],
            ['name' => 'Anna Schmidt', 'email' => 'anna.schmidt@gmx.de', 'country' => 'Germany'],
            ['name' => 'Pierre Dubois', 'email' => 'pierre.dubois@orange.fr', 'country' => 'France'],
            ['name' => 'Lisa Anderson', 'email' => 'lisa.anderson@outlook.com', 'country' => 'USA'],
            ['name' => 'Michael Brown', 'email' => 'michael.brown@gmail.com', 'country' => 'USA'],
            ['name' => 'Sarah Wilson', 'email' => 'sarah.wilson@icloud.com', 'country' => 'Canada'],
            ['name' => 'David Chen', 'email' => 'david.chen@gmail.com', 'country' => 'Australia'],
            ['name' => 'Yuki Tanaka', 'email' => 'yuki.tanaka@yahoo.co.jp', 'country' => 'Japan'],
            ['name' => 'Olga Petrov', 'email' => 'olga.petrov@gmail.com', 'country' => 'Russia'],
            ['name' => 'Carlos Rodriguez', 'email' => 'carlos.rodriguez@outlook.com', 'country' => 'Spain'],
            ['name' => 'Maria Santos', 'email' => 'maria.santos@gmail.com', 'country' => 'Portugal'],
            ['name' => 'Peter Nielsen', 'email' => 'peter.nielsen@live.dk', 'country' => 'Denmark'],
            ['name' => 'Ingrid Larsson', 'email' => 'ingrid.larsson@outlook.com', 'country' => 'Sweden'],
            ['name' => 'Jan Kowalski', 'email' => 'jan.kowalski@gmail.com', 'country' => 'Poland'],
            ['name' => 'Klaus Weber', 'email' => 'klaus.weber@gmail.com', 'country' => 'Switzerland'],
            ['name' => 'Marie Dupont', 'email' => 'marie.dupont@free.fr', 'country' => 'France'],
            ['name' => 'Robert Taylor', 'email' => 'robert.taylor@gmail.com', 'country' => 'United Kingdom'],
            ['name' => 'Jennifer White', 'email' => 'jennifer.white@yahoo.com', 'country' => 'USA'],
            ['name' => 'Thomas Garcia', 'email' => 'thomas.garcia@gmail.com', 'country' => 'Spain'],
            ['name' => 'Linda Martinez', 'email' => 'linda.martinez@outlook.com', 'country' => 'Mexico'],
            ['name' => 'Paul Jackson', 'email' => 'paul.jackson@gmail.com', 'country' => 'United Kingdom'],
            ['name' => 'Nancy Harris', 'email' => 'nancy.harris@icloud.com', 'country' => 'USA'],
            ['name' => 'Frank Moore', 'email' => 'frank.moore@yahoo.com', 'country' => 'Canada'],
            ['name' => 'Betty Clark', 'email' => 'betty.clark@gmail.com', 'country' => 'USA'],
            ['name' => 'George Lewis', 'email' => 'george.lewis@outlook.com', 'country' => 'United Kingdom'],
            ['name' => 'Helen Walker', 'email' => 'helen.walker@gmail.com', 'country' => 'Ireland'],
            ['name' => 'Edward Hall', 'email' => 'edward.hall@yahoo.com', 'country' => 'United Kingdom'],
        ];

        $createdGuests = 0;
        foreach ($guestsData as $index => $data) {
            $existing = User::where('email', $data['email'])->first();
            if (!$existing) {
                User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt('password'),
                    'country' => $data['country'],
                    'role' => 'user',
                    'is_verified' => true,
                    'is_host' => false,
                    'preferred_language' => 'en',
                    'preferred_currency' => 'USD',
                ]);
                $createdGuests++;
            }
        }
        $this->command->info("✅ Created {$createdGuests} guest users (email: guest_name@email.com / password)");

        $this->command->info('');
        $this->command->info('📧 Login credentials:');
        $this->command->info('   Admin: admin@jubbastay.com / password');
        $this->command->info('   Hosts: hostN@jubbastay.com / password (15 hosts)');
        $this->command->info('   Guests: guest_name@email.com / password (30 guests)');
    }
}
