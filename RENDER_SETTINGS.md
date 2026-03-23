# 🚀 RENDER SETTINGS - EXACTLY WHAT TO CHANGE

## Current Settings (WRONG):
```
Language: Node ❌
Build: npm install; npm run build ❌
Start: yarn start ❌
```

## What You Need To Change:

### 1️⃣ CHANGE LANGUAGE: Node → PHP 8.2
**On your screen, click the "Language" dropdown**
- Look for **"Node"** (current)
- Change it to **"PHP 8.2"** ⭐ CRITICAL

### 2️⃣ CHANGE BUILD COMMAND
**Click and replace the Build Command:**
```
BEFORE: npm install; npm run build
AFTER:  composer install --no-dev --optimize-autoloader
```

### 3️⃣ CHANGE START COMMAND
**Click and replace the Start Command:**
```
BEFORE: yarn start
AFTER:  php -S 0.0.0.0:10000 -t public
```

### 4️⃣ LEAVE ROOT DIRECTORY EMPTY
- Root Directory: (leave empty/blank)

### 5️⃣ ADD ENVIRONMENT VARIABLES
Click **"Add Environment Variable"** button and add these ONE BY ONE:

```
APP_ENV = production
APP_DEBUG = false
APP_KEY = (leave this one EMPTY)
DB_CONNECTION = pgsql
DB_PORT = 5432
```

### 6️⃣ Click "Create Web Service" ✅

---

## ⚠️ IMPORTANT:
After creating, you'll need to:
1. Create PostgreSQL database
2. Add DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD environment variables
3. Run `php artisan migrate` in Shell
