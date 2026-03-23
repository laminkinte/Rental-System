# 🚀 RENDER DEPLOYMENT - STEP BY STEP

## ⚠️ PROBLEM IDENTIFIED
Your current service is configured as **Node.js** instead of **PHP**. 
The service is using OLD code (commit 7750ee9) instead of the new one.

## ✅ SOLUTION: Delete and Recreate with PHP

---

## STEP 1: DELETE OLD SERVICE (5 seconds)

1. Go to: https://dashboard.render.com
2. Find your **"Rental-System"** service
3. Click on it to open
4. Look for **"Settings"** (top menu)
5. Scroll to the very bottom
6. Click **"Delete Service"** (red button)
7. Type "Rental-System" to confirm
8. Click **"Delete"**

✅ Service deleted!

---

## STEP 2: CREATE NEW PHP SERVICE (2 minutes)

1. Go to: https://dashboard.render.com
2. Click **"New +"** (top right)
3. Click **"Web Service"**

### Configure the Service:

**Step 2a: Connect GitHub**
- Click **"Configure account"** if prompted
- Find **"laminkinte/Rental-System"**
- Click **"Connect"**

**Step 2b: Configure Settings** ⭐ CRITICAL

```
Name: rental-system
Description: (optional)
Region: Oregon (or Singapore)
Runtime: ⭐ PHP 8.2  ← SELECT THIS (NOT Node!)
Branch: main
Root Directory: (leave empty)
```

**Step 2c: Build & Deploy Settings**

```
Build Command:
composer install --no-dev --optimize-autoloader

Publish Directory:
public

Start Command:
php -S 0.0.0.0:10000 -t public
```

**Step 2d: Plan**
```
Plan: Free
```

**Step 2e: Add Environment Variables**

Click **"Advanced"** → **"Add Environment Variable"**

Add these ONE BY ONE:

```
APP_ENV = production
APP_DEBUG = false
APP_KEY = (leave empty - will auto-generate)
DB_CONNECTION = pgsql
DB_PORT = 5432
```

**Step 2f: Click "Create Web Service"** ✅

---

## STEP 3: CREATE POSTGRESQL DATABASE (2 minutes)

While your service is deploying:

1. Click **"New +"** (top right)
2. Click **"PostgreSQL"**

```
Name: rental-system-db
Database: rental_system
User: rental_system_user
Region: Oregon (same as web service!)
Plan: Free
```

3. Click **"Create Database"**
4. Wait 1-2 minutes for it to provision
5. Copy the **"Internal Database URL"**

---

## STEP 4: CONNECT DATABASE TO WEB SERVICE

1. Go back to your Web Service
2. Click **"Environment"** (top menu)
3. Add these environment variables:

```
DB_HOST = (paste from PostgreSQL Internal URL)
DB_DATABASE = rental_system
DB_USERNAME = (from PostgreSQL)
DB_PASSWORD = (from PostgreSQL)
```

4. Click **"Save Changes"**
5. Click **"Manual Deploy"** → **"Deploy last commit"**

---

## STEP 5: RUN MIGRATIONS (1 minute)

1. After service is deployed, click **"Shell"**
2. In the terminal, type:
   ```
   php artisan migrate
   ```
3. Press Enter
4. Wait for migrations to complete

✅ Database tables created!

---

## STEP 6: ACCESS YOUR APP! 🎉

1. Go to your Web Service
2. Click the URL (e.g., https://rental-system-xxxx.onrender.com)
3. Your Rental System should be LIVE!

---

## 🔍 TROUBLESHOOTING

### Error: "Root directory app.js does not exist"
**Cause:** Wrong runtime selected
**Fix:** You must select PHP 8.2 (not auto-detect)

### Error: "Database connection failed"
**Fix:** 
- Wait 2 minutes for PostgreSQL to fully provision
- Verify DB credentials in Environment variables
- Check DB_HOST matches PostgreSQL Internal URL

### Error: "APP_KEY is missing"
**Fix:**
- Leave APP_KEY empty in env vars
- It auto-generates during build
- If still missing, run in Shell: `php artisan key:generate`

### Service stuck in "Building"
**Fix:**
- Check logs for errors
- Common: Missing environment variables
- Wait 5 minutes max, then check

---

## 💰 COST: $0 FOREVER!

- ✅ Web Service: FREE (750h/month)
- ✅ PostgreSQL: FREE (1GB storage)
- ✅ SSL: FREE
- ✅ Auto-deploys: FREE

---

## 📋 QUICK CHECKLIST

- [ ] Delete old Node.js service
- [ ] Create new Web Service
- [ ] Select PHP 8.2 runtime ⭐
- [ ] Set Build Command: `composer install --no-dev --optimize-autoloader`
- [ ] Set Start Command: `php -S 0.0.0.0:10000 -t public`
- [ ] Create PostgreSQL database
- [ ] Add DB environment variables
- [ ] Deploy!
- [ ] Run `php artisan migrate`
- [ ] Access your app!

---

## 🎉 SUCCESS!

If you followed all steps, your Rental System is now LIVE at:
`https://rental-system-xxxx.onrender.com`

Share your link! 🚀
