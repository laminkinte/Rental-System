# 🚀 RAILWAY DEPLOYMENT GUIDE

Railway is a great alternative to Render and supports PHP!

---

## STEP 1: Create Railway Account
1. Go to: https://railway.app
2. Sign up with GitHub
3. Click "New Project"

---

## STEP 2: Create New Project
1. Select **"Deploy from GitHub repo"**
2. Select: `laminkinte/Rental-System`
3. Click "Deploy"

---

## STEP 3: Configure Environment

### Add Environment Variables in Railway Dashboard:

```
APP_ENV = production
APP_DEBUG = false
DB_CONNECTION = pgsql
DB_HOST = (will be auto-filled when you add database)
DB_DATABASE = (will be auto-filled)
DB_USERNAME = (will be auto-filled)
DB_PASSWORD = (will be auto-filled)
```

---

## STEP 4: Add PostgreSQL Database

1. In Railway project dashboard:
2. Click **"+ New"**
3. Select **"Database"** → **"PostgreSQL"**
4. Wait for it to provision
5. The database will automatically connect!

---

## STEP 5: Add Variables

After adding PostgreSQL, Railway auto-fills these. Make sure you have:
- DB_HOST
- DB_DATABASE  
- DB_USERNAME
- DB_PASSWORD

---

## STEP 6: Deploy

1. Click "Deploy" in Railway
2. Wait for build to complete
3. Build command: `composer install --no-dev --optimize-autoloader`

---

## STEP 7: Run Migrations

1. Click on your deployed service
2. Click "Shell" or "Terminal"
3. Run: `php artisan migrate`

---

## ✅ DONE!

Your app will be live at: `https://your-project-name.up.railway.app`

---

## 💰 COST: FREE!

- ✅ 500 hours/month (Free)
- ✅ PostgreSQL included (Free)
- ✅ SSL included (Free)

---

## TROUBLESHOOTING

### Build failed?
Check the logs - may need to adjust the build command in Railway settings.

### Database connection error?
Make sure all DB_* environment variables are set correctly.

### Need to restart?
Click "Redeploy" in Railway dashboard
