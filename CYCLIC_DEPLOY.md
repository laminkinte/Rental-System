# 🚀 DEPLOY ON CYCLIC (100% FREE - NO CREDIT CARD)

## WHY CYCLIC?
- ✅ 100% FREE forever
- ✅ No credit card required
- ✅ GitHub auto-deploy
- ✅ PHP/Laravel support
- ✅ Free SSL

---

## STEP 1: Create Cyclic Account

1. Go to: https://app.cyclic.sh
2. Click **"Sign up"**
3. Choose **"Continue with GitHub"**
4. Authorize the connection

---

## STEP 2: Import Your Project

1. Click **"+ New App"** or **"Connect Repo"**
2. Find: `laminkinte/Rental-System`
3. Click **"Connect"**

---

## STEP 3: Configure Build Settings

In Cyclic dashboard:

### Build Command:
```
composer install --no-dev --optimize-autoloader
```

### Node Version:
Leave as default (Cyclic will use PHP)

---

## STEP 4: Add Environment Variables

Click **"Variables"** and add:

```
APP_ENV = production
APP_DEBUG = false
APP_KEY = (generate one locally first)
DB_CONNECTION = pgsql
DB_HOST = your-postgres-host
DB_PORT = 5432
DB_DATABASE = rental_system
DB_USERNAME = your-username
DB_PASSWORD = your-password
```

---

## STEP 5: Create Free PostgreSQL Database

### Option A: Neon.tech (Recommended)
1. Go to: https://neon.tech
2. Sign up (free, no credit card)
3. Create project: `rental-system`
4. Copy connection string
5. Use as DB_HOST, DB_DATABASE, etc.

### Option B: Supabase
1. Go to: https://supabase.com
2. Sign up (free, no credit card)
3. Create project
4. Get connection details

---

## STEP 6: Connect Database

Update environment variables with Neon/Supabase credentials:

```
DB_HOST = your-neon-host.neon.tech
DB_DATABASE = rental_system
DB_USERNAME = your-username
DB_PASSWORD = your-password
```

---

## STEP 7: Deploy

1. Click **"Deploy"** button in Cyclic
2. Wait for build to complete (2-5 minutes)
3. Check logs for errors

---

## STEP 8: Run Migrations

1. In Cyclic dashboard, find **"Shell"** or **"Terminal"**
2. Or trigger via POST to `/up` route
3. Run: `php artisan migrate`

---

## STEP 9: Access Your App!

Your app will be live at:
`https://your-app-name.cyclic.app`

---

## ⚠️ IMPORTANT NOTES

### Cold Start
- Cyclic sleeps after 30 minutes of inactivity
- First request takes 50 seconds to wake up
- Perfect for development/demo

### Environment Variables
- APP_KEY must be set manually
- Generate with: `php artisan key:generate`

### Database Connection
- Neon/Supabase must allow connections from Cyclic
- In Neon: Settings → Connection → Allow all IPs

---

## 🔧 TROUBLESHOOTING

### Build Failed?
Check Cyclic logs - common issues:
1. Missing APP_KEY
2. Database connection failed
3. Composer error

### Database Error?
1. Verify DB credentials
2. Check Neon/Supabase allowlist
3. Ensure DB_PORT is 5432

### 500 Error?
1. Run `php artisan migrate`
2. Check `.env` variables
3. Verify APP_KEY is set

---

## 💰 COST: $0 FOREVER

- ✅ App hosting: FREE
- ✅ SSL: FREE
- ✅ Neon database: FREE (3GB)
- ✅ Total cost: $0

---

## 🎉 SUCCESS!

Your Rental System is now LIVE for FREE!
