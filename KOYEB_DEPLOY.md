# 🚀 DEPLOY ON KOYEB (GITHUB AUTO-DEPLOY)

Koyeb is a developer-friendly platform with **GitHub auto-deploy** and free tier!

---

## ✅ FREE TIER FEATURES:
- 100GB bandwidth/month
- 0.5GB RAM
- 1 web service
- GitHub auto-deploy
- SSL included
- PostgreSQL database option

---

## STEP 1: Create Koyeb Account

1. Go to: https://www.koyeb.com
2. Click **"Get Started"**
3. Sign up with **GitHub** (easiest!)
4. Authorize Koyeb on GitHub

---

## STEP 2: Deploy from GitHub

1. Click **"Create App"** or **"New Service"**
2. Select **"Deploy from GitHub repository"**
3. Find your repo: `laminkinte/Rental-System`
4. Click **"Deploy"**

---

## STEP 3: Configure Environment

In the deployment settings:

### Build Command:
```bash
composer install --no-dev --optimize-autoloader && php artisan migrate --force && php artisan key:generate --force
```

### Run Command:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### Environment Variables:
```
APP_ENV=production
APP_DEBUG=false
APP_KEY=  (leave empty - auto-generated)
DB_CONNECTION=pgsql
DB_HOST=  (your Neon host)
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=  (your Neon username)
DB_PASSWORD=  (your Neon password)
```

---

## STEP 4: Add Database

### Option A: Koyeb Postgres (Recommended for Free)
1. In Koyeb dashboard → **"Marketplace"** or **"Services"**
2. Click **"Create Service"** → **"Database"**
3. Select **PostgreSQL**
4. Create database
5. Note connection details
6. Link to your app

### Option B: Use Neon Database
1. Use your Neon credentials above
2. Make sure Neon allows connections from Koyeb IPs

---

## STEP 5: Wait for Deployment

Koyeb will:
1. Clone from GitHub
2. Run composer install
3. Run migrations
4. Start your app
5. Provide a URL like: `https://your-app-name.koyeb.app`

---

## 🌐 ACCESS YOUR SITE:

Your app will be live at: `https://rental-system.koyeb.app`

---

## 🔄 AUTO-DEPLOY SETUP:

Once deployed, every push to GitHub will automatically trigger a new deployment!

---

## 💰 COST: FREE (with limits)

- Free tier: 100GB bandwidth/month
- No credit card required for GitHub signup

---

## ⚠️ LARAVEL SPECIFIC NOTES:

### Important Files to Include:
- `composer.json` ✅
- `.env` (or environment variables) ✅
- `artisan` ✅
- All Laravel folders ✅

### Storage Link:
After deployment, run via Koyeb console:
```bash
php artisan storage:link
```

---

## 🔧 TROUBLESHOOTING:

### Build Fails?
- Check build logs in Koyeb dashboard
- Make sure PHP version is compatible
- Check environment variables

### Database Connection Error?
- Verify Neon allows Koyeb IPs
- Or use Koyeb's built-in PostgreSQL

### 500 Error?
- Check `APP_DEBUG=true` temporarily
- Verify `APP_KEY` is set
- Check storage permissions

---

## ✅ DEPLOY NOW:

1. Go to https://www.koyeb.com
2. Sign up with GitHub
3. Deploy `laminkinte/Rental-System`
4. Done!

Your site will be live with auto-deploy from GitHub! 🚀
