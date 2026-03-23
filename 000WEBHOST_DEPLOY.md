# 🚀 DEPLOY ON 000WEBHOSTING

000WebHosting is a free hosting service by Hostinger.

---

## ✅ FREE FEATURES:
- 300MB storage
- PHP support
- MySQL databases
- No credit card
- File Manager

---

## STEP 1: Create Account

1. Go to: https://www.000webhosting.com
2. Click **"Get Free Hosting"**
3. Sign up with email
4. Verify email

---

## STEP 2: Create Website

1. Click **"Create Site"**
2. Name your site: `Rental-System`
3. Select **"Upload your own website"**
4. Click **"Next"**

---

## STEP 3: Upload Files

### Method A: File Manager
1. In control panel → **"File Manager"**
2. Navigate to `/public_html`
3. Delete default files
4. Upload your Laravel `public` folder contents here

### Method B: FTP
1. Get FTP details from dashboard
2. Use FileZilla
3. Connect and upload files

---

## STEP 4: Setup Database

1. Go to **"Database"** → **"MySQL"**
2. Create database
3. Note credentials:
   - Host: `sql313.000webhost.com`
   - Database name
   - Username
   - Password

---

## STEP 5: Configure Laravel

1. Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=sql313.000webhost.com
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

2. Upload `.env` to `/public_html`

---

## LARAVEL FILE STRUCTURE:

Upload to `/public_html`:
```
/public_html/
  ├── index.php
  ├── .htaccess
  ├── css/
  ├── js/
  ├── images/
  └── ...
```

Move other folders (app, bootstrap, config, etc.) above public_html or use .htaccess routing.

---

## ⚠️ LARAVEL ON SHARED HOSTING:

000WebHosting is shared hosting - no SSH/Composer. 

### Solution:
1. Run `composer install` LOCALLY first
2. Upload the `/vendor/` folder
3. Database migrations must be done via phpMyAdmin

---

## IMPORT DATABASE MANUALLY:

1. Export local database as SQL:
```bash
php artisan migrate --seed
```

2. In 000webhost → **"Database"** → **"phpMyAdmin"**
3. Import the SQL file

---

## ⚠️ LIMITATIONS:

- No SSH access
- No Composer
- No Artisan commands
- Limited PHP extensions
- May not support all Laravel features

---

## 🌐 ACCESS YOUR SITE:

Your site will be at: `https://rental-system.000webhostapp.com`

---

## 💰 COST: FREE

No credit card required!
