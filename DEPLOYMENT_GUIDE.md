# 🚀 FREE HOSTING DEPLOYMENT GUIDE

## Best Free Hosting Options for Laravel

### 🥇 RENDER.COM (Recommended)
**Free Tier:** 750 hours/month, sleep after 15 min inactivity

**Setup Steps:**

1. **Create Account:** https://render.com
2. **Connect GitHub:** Authorize Render to access your repository
3. **Create Web Service:**
   - Click "New +" → "Web Service"
   - Connect your `Rental-System` repository
   - Configure:
     - **Root Directory:** (leave empty)
     - **Runtime:** PHP
     - **Build Command:** `composer install`
     - **Publish Directory:** `public`
     - **PHP Version:** 8.2
     - **Start Command:** `php artisan serve --port=10000 --host=0.0.0.0`

4. **Add Environment Variables:**
   ```
   APP_ENV=production
   APP_KEY= (generate with php artisan key:generate)
   APP_URL= https://your-app.onrender.com
   DB_CONNECTION= postgres (use Render's free PostgreSQL)
   DB_HOST= (from Render PostgreSQL)
   DB_PORT=5432
   DB_DATABASE=rental_system
   DB_USERNAME= (your PostgreSQL username)
   DB_PASSWORD= (your PostgreSQL password)
   ```

5. **Create PostgreSQL Database:**
   - New → PostgreSQL
   - Free tier: 1GB storage
   - Copy connection details to your Web Service

6. **Deploy:**
   - Click "Create Web Service"
   - Auto-deploys on every GitHub push!

---

### 🥈 RAILWAY.app
**Free Tier:** $5 credit/month, 500 hours

**Setup Steps:**

1. **Create Account:** https://railway.app
2. **New Project → Deploy from GitHub repo**
3. **Add PostgreSQL Plugin:**
   - Click on your project → Add Plugin → PostgreSQL
4. **Set Environment Variables:**
   - Same as Render above
5. **Deploy Button:**
   ```
   Build Command: composer install --no-dev --optimize-autoloader
   Start Command: php artisan serve --port=8080 --host=0.0.0.0
   ```

---

### 🥉 CYCLIC
**Free Tier:** Unlimited requests, 128MB RAM

**Setup Steps:**

1. **Create Account:** https://www.cyclic.sh
2. **Connect GitHub** and select `Rental-System`
3. **Configure:**
   - Framework: Node (for build) or PHP
   - Or use Dockerfile

---

## 📋 Pre-Deployment Checklist

### 1. Create Production `.env`
```bash
cp .env.example .env
php artisan key:generate
```

### 2. Update `.env` for Production
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Use PostgreSQL (free tiers available)
DB_CONNECTION=pgsql
DB_HOST=your-database-host
DB_PORT=5432
DB_DATABASE=rental_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. Important Files to Configure

**Create `public/index.php` if needed:**
```php
<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
```

**Create/Update `.htaccess` in public:**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{REQUEST_URI} !/public
    RewriteRule ^(.*)$ /public/$1 [L,R=301]
</IfModule>
```

### 4. GitHub Actions for Auto-Deployment (Render)

Create `.github/workflows/deploy.yml`:
```yaml
name: Deploy to Render

on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      
      - name: Install Dependencies
        run: composer install --no-dev --optimize-autoloader
      
      - name: Generate Key
        run: php artisan key:generate
      
      - name: Run Migrations
        run: php artisan migrate --force
        env:
          DB_CONNECTION: pgsql
          DB_HOST: ${{ secrets.DB_HOST }}
          DB_PORT: 5432
          DB_DATABASE: rental_system
          DB_USERNAME: ${{ secrets.DB_USERNAME }}
          DB_PASSWORD: ${{ secrets.DB_PASSWORD }}
```

---

## 🗄️ Free Database Options

1. **Render PostgreSQL** - 1GB free
2. **ElephantSQL** - 20MB free (TINY)
3. **Neon PostgreSQL** - 3GB free
4. **Supabase** - 500MB free

---

## 🎯 Recommended: Render + Neon PostgreSQL

**Why:** Best free tier combination with good performance

**Steps:**
1. Deploy to Render (as shown above)
2. Create Neon PostgreSQL database (3GB free)
3. Use Neon connection string in Render

---

## ⚠️ Important Notes

### For Laravel 11:
- Make sure `bootstrap/app.php` is configured correctly
- Run `php artisan serve` doesn't work on all hosts
- Some hosts require custom start commands

### Database Considerations:
- MySQL is NOT available on most free tiers
- Use PostgreSQL (works everywhere free)
- Update your `config/database.php` accordingly

### Storage:
- Free hosts don't have persistent storage
- Use cloud storage (AWS S3, Cloudinary) for uploads
- Or use base64 encoding for small files

### HTTPS:
- All free hosts provide free SSL certificates
- Update `APP_URL` to `https://`

---

## 📊 Quick Comparison

| Platform | Free Tier | Sleep? | Custom Domain | SSL |
|----------|-----------|--------|---------------|-----|
| **Render** | 750h/month | After 15min | ✅ Free | ✅ Free |
| **Railway** | $5 credit | No sleep | ✅ Free | ✅ Free |
| **Cyclic** | Unlimited | No sleep | ❌ | ✅ Free |
| **Vercel** | 100h/month | After 24h | ✅ Limited | ✅ Free |

---

## 🎉 Quick Start: Render

1. Go to https://render.com
2. Connect GitHub: `laminkinte/Rental-System`
3. Create PostgreSQL (New → PostgreSQL)
4. Create Web Service
5. Add environment variables from PostgreSQL
6. Set Build Command: `composer install`
7. Set Start Command: `php artisan serve --port=10000 --host=0.0.0.0`
8. Deploy!

---

## 💡 Pro Tips

1. **First Deployment:** Allow 5-10 minutes for initial setup
2. **Errors:** Check Render logs for deployment issues
3. **Database:** Always use environment variables, never hardcode
4. **Composer:** Use `--no-dev` in production for faster deploys
5. **Caching:** Run `php artisan config:cache` after deployment
6. **HTTPS:** Always use HTTPS in production

---

## 🆘 Need Help?

- **Render Docs:** https://render.com/docs
- **Laravel Deployment:** https://laravel.com/docs/deployment
- **GitHub Issues:** Check repository for known issues
