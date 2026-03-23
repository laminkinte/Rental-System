# 🚀 MANUAL UPLOAD TO INFINITYFREE

InfinityFree does NOT have GitHub integration. You must manually upload files.

---

## METHOD 1: InfinityFree File Manager (Easiest)

### Step 1: Create Account
1. Go to https://infinityfree.net
2. Click "Get Free Hosting"
3. Sign up with email

### Step 2: Create Account
1. Create new account
2. Wait for activation email
3. Click link in email

### Step 3: Create Site
1. Click "Create Account"
2. Choose free subdomain: `yourname.42web.io`
3. Complete setup

### Step 4: Upload Files
1. In control panel, click "Control Panel"
2. Click "Online File Manager"
3. Navigate to `/htdocs`
4. **DELETE** default `index.html`
5. Click "Upload" button
6. **Upload ALL your Laravel files** (drag and drop)

### Step 5: Setup Database
1. Go to "MySQL Databases"
2. Create database
3. Note down: hostname, database name, username, password

### Step 6: Configure Laravel
1. Find `.env` file in uploaded files
2. Edit with Notepad++
3. Update database settings:
```
DB_CONNECTION=mysql
DB_HOST=sql307.42web.io
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 7: Run Migrations
1. Go to "PHP Version" in control panel
2. Check PHP version
3. Use phpMyAdmin to import database manually

---

## METHOD 2: Use Local Computer + ZIP Upload

### Step 1: Create ZIP Locally
1. Open File Explorer
2. Go to your Laravel project folder
3. Select ALL files
4. Right-click → "Send to" → "Compressed (zipped) folder"

### Step 2: Upload ZIP to InfinityFree
1. In File Manager
2. Upload the ZIP file to `/htdocs`
3. Right-click ZIP → "Extract"

---

## METHOD 3: Download from GitHub, Upload to InfinityFree

### Step 1: Download from GitHub
1. Go to: https://github.com/laminkinte/Rental-System
2. Click "Code" → "Download ZIP"
3. Save to computer

### Step 2: Extract ZIP
1. Right-click ZIP
2. "Extract All"
3. Extract to folder

### Step 3: Upload to InfinityFree
1. Go to InfinityFree File Manager
2. Upload all extracted files to `/htdocs`

---

## LARAVEL SPECIFIC NOTES:

### File Structure to Upload:
```
/public/        → Upload to /htdocs/
/storage/       → Upload to /htdocs/storage
bootstrap/      → Upload to /htdocs/bootstrap
vendor/         → Upload to /htdocs/vendor
.env            → Upload to /htdocs/
artisan         → Upload to /htdocs/
composer.json   → Upload to /htdocs/
```

### Important:
- `/node_modules/` - DO NOT upload (not needed)
- `/vendor/` - MUST upload (Laravel dependencies)

### Configuration:
Edit `/htdocs/.env` with your InfinityFree database info

---

## ⚠️ LIMITATIONS OF INFINITYFREE:

- No SSH access
- No Composer
- No Artisan commands
- Limited PHP functions

### Workaround:
Run `composer install` locally, then upload `/vendor/` folder

---

## ✅ QUICKEST METHOD:

1. Download ZIP from GitHub
2. Extract locally
3. Run `composer install` locally
4. Edit `.env` with database info
5. Upload all to InfinityFree via File Manager
