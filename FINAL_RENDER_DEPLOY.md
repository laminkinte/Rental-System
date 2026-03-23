# 🚀 FINAL DEPLOYMENT STEPS - SELECT PHP!

## STEP 1: Delete Old Service
1. Go to https://dashboard.render.com
2. Find "Rental-System" service
3. Settings → Delete Service

## STEP 2: Create New Web Service

### CRITICAL: Select PHP from Language Dropdown!
When creating new service:
1. **Language**: Find dropdown and select **PHP** (not Node!)
2. **Build Command**: `composer install --no-dev --optimize-autoloader`
3. **Start Command**: `php -S 0.0.0.0:10000 -t public`

### Environment Variables:
```
APP_ENV = production
APP_DEBUG = false
APP_KEY = (leave EMPTY)
DB_CONNECTION = pgsql
DB_PORT = 5432
```

## STEP 3: Create PostgreSQL
- New → PostgreSQL
- Name: rental-system-db
- Plan: Free

## STEP 4: Connect Database
Add these env vars from PostgreSQL:
```
DB_HOST = (from PostgreSQL)
DB_DATABASE = rental_system
DB_USERNAME = (from PostgreSQL)
DB_PASSWORD = (from PostgreSQL)
```

## STEP 5: Deploy
- Manual Deploy → Deploy last commit

## STEP 6: Run Migrations
- Shell → `php artisan migrate`

## ✅ DONE! Your app will be live!
