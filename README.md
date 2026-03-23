# Rental System - Property Rental Platform

A comprehensive property rental management system built with Laravel and Livewire.

## Features

### For Guests
- Browse and search available properties
- View property details and availability
- Make bookings with multiple payment options
- Leave reviews for properties

### For Hosts
- List and manage properties
- Set dynamic pricing
- View booking requests
- Access host dashboard with reports

### For Admins
- Complete admin dashboard
- User management
- Property management
- Booking management
- Review moderation
- System settings

### Core Features
- User authentication (email, magic link, OTP)
- Multiple payment methods
- Digital wallets
- Real-time messaging
- Notifications system
- Sustainability tracking
- Global compliance checks
- Group bookings
- Role-based access control

## Requirements

- PHP 8.2+
- Laravel 11.x
- MySQL 8.0+
- Node.js 18+
- Composer

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Copy environment file:
   ```bash
   cp .env.example .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Run migrations:
   ```bash
   php artisan migrate
   ```

6. Seed the database (optional):
   ```bash
   php artisan db:seed
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

## Free Hosting Options

- **Render.com** - Free tier with auto-deploy
- **Railway.app** - Free tier available
- **Vercel** - Frontend hosting (requires API adaptation)
- **Heroku** - Free tier available

## Tech Stack

- **Backend:** Laravel 11, PHP 8.2
- **Frontend:** Livewire, TailwindCSS
- **Database:** MySQL
- **Real-time:** Laravel Echo, Pusher
- **Payments:** Stripe, PayPal integration ready

## License

This project is private and proprietary. All rights reserved.
