# 🚀 NEON.TECH POSTGRESQL SETUP FOR LARAVEL

Neon provides **free PostgreSQL** - 3GB storage, no credit card!

---

## STEP 1: Create Neon Account

1. Go to: https://neon.tech
2. Click **"Sign Up"**
3. Choose **"Continue with GitHub"**
4. Authorize Neon

---

## STEP 2: Create New Project

1. Click **"Create a project"**
2. Name: `rental-system`
3. Click **"Create project"**
4. Wait for it to provision

---

## STEP 3: Get Connection Details

After creation, you'll see connection details:

```
Host: your-project-name.us-east-1.aws.neon.tech
Database: neondb
User: your-username
Password: your-password
```

**OR** copy the **Connection String**:
```
postgresql://username:password@host/neondb?sslmode=require
```

---

## STEP 4: Configure Laravel

Update your `.env` file or Cyclic environment variables:

```
DB_CONNECTION=pgsql
DB_HOST=your-project-name.us-east-1.aws.neon.tech
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

---

## STEP 5: Allow External Connections

By default, Neon requires IP allowlisting. For development:

1. In Neon dashboard: **Settings** → **Connection**
2. Find **"IP Allow"** or **"Connection pooling"**
3. Select **"Pooled"** connection (uses different port: 6543)
4. Or add your IP address

**For Cyclic deployment:**
- Use the **Connection String** with `?sslmode=require`
- Neon automatically allows connections from cloud platforms

---

## STEP 6: Test Connection

Run locally:
```bash
php artisan migrate
```

If connection fails, check:
1. Password is correct
2. Use correct host (not the pooled one)
3. Add `?sslmode=require` to connection string

---

## STEP 7: Get Credentials for Deployment

### Option A: Connection String (Recommended for Laravel)
```
postgresql://username:password@host/neondb?sslmode=decode
```

### Option B: Individual Values
```
DB_HOST = your-project.us-east-1.aws.neon.tech
DB_PORT = 5432
DB_DATABASE = neondb
DB_USERNAME = your-username
DB_PASSWORD = your-password
```

---

## 🔧 LARAVEL CONFIGURATION

### Update config/database.php if needed:

```php
'pgsql' => [
    'driver' => 'pgsql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'prefix' => '',
    'prefix_indexes' => true,
    'search_path' => 'public',
    'sslmode' => 'prefer',
],
```

---

## 💰 NEON PRICING

| Plan | Storage | Monthly |
|------|---------|---------|
| **Free** | 3GB | $0 |
| Scale | 100GB | $69/mo |

**Your app: FREE forever with 3GB!**

---

## ⚠️ IMPORTANT NOTES

### Cold Start
- Neon is always-on (no cold start)
- Connection may timeout after 5 min inactivity
- Use connection pooling for better performance

### SSL Required
- Always add `?sslmode=require` to connection string
- Or set `DB_SSLMODE=require` in .env

### Password Special Characters
- If password has special chars (`@`, `#`, etc.), URL encode them
- `@` → `%40`
- `#` → `%23`

---

## 🔗 CONNECTING TO CYCLIC

In Cyclic dashboard → Variables, add:

```
DB_CONNECTION=pgsql
DB_HOST=your-neon-project.us-east-1.aws.neon.tech
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

---

## ✅ DONE!

Your PostgreSQL database is ready at Neon.tech!

Now deploy your Laravel app on Cyclic and connect to Neon.
