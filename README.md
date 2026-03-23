# 🚀 Rental System - Property Rental Platform

A comprehensive property rental management system built with Laravel and Livewire.

---

## 🌐 LIVE DEMO DEPLOYMENT

**Your GitHub Repo:** https://github.com/laminkinte/Rental-System

---

## 📋 DEPLOYMENT OPTIONS

### ✅ OPTION 1: 000WEBHOSTING (RECOMMENDED - NO CREDIT CARD)

**100% FREE - PHP Hosting with MySQL**

#### Steps:
1. Go to: **https://www.000webhosting.com**
2. Click **"Get Free Hosting"**
3. Sign up with email (NO credit card!)
4. Create site → Select **"Upload your own website"**
5. Upload files via **File Manager** to `/public_html`
6. Create MySQL database
7. Edit `.env` with database credentials

#### Database Settings:
```
DB_CONNECTION=mysql
DB_HOST=sql313.000webhost.com
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### Your Site URL:
`https://rental-system.000webhostapp.com`

---

### ⚠️ Platforms Requiring Credit Card:

| Platform | Auto-Deploy | Credit Card Required |
|----------|-------------|---------------------|
| Koyeb | ✅ Yes | ❌ Yes |
| Render | ✅ Yes | ❌ Yes |
| Fly.io | ✅ Yes | ❌ Yes |
| Railway | ✅ Yes | ❌ Yes |
| Oracle Cloud | ✅ Yes | ❌ Sometimes |

---

## 📁 ALL DEPLOYMENT GUIDES

| File | Description |
|------|-------------|
| `000WEBHOST_DEPLOY.md` | 000WebHosting setup |
| `UPLOAD_TO_INFINITYFREE.md` | InfinityFree setup |
| `KOYEB_DEPLOY.md` | Koyeb (needs card) |
| `NETLIFY_LARAVEL.md` | Netlify (PHP limited) |
| `FREE_HOSTING_ALTERNATIVES.md` | All options |
| `NEON_SETUP.md` | Free PostgreSQL database |

---

## ✨ Features

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

---

## 💻 Tech Stack

- **Backend:** Laravel 11, PHP 8.2
- **Frontend:** Livewire, TailwindCSS
- **Database:** MySQL (local), PostgreSQL (production)
- **Real-time:** Laravel Echo, Pusher
- **Payments:** Stripe, PayPal integration ready

---

## 🔧 Local Development

### Requirements
- PHP 8.2+
- Laravel 11.x
- MySQL 8.0+ / PostgreSQL
- Node.js 18+
- Composer

### Setup
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

---

## 📞 SUPPORT

For deployment help, check the guides in this repository or create an issue on GitHub.

---

## 📄 License

This project is private and proprietary. All rights reserved.
