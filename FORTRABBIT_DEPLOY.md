# 🚀 Deploy to Fortrabbit

## Step 1: Create Fortrabbit Account

1. Go to https://www.fortrabbit.com
2. Sign up for an account
3. Create a new "App" with PHP/Laravel template (choose "Starter" plan for MySQL)

## Step 2: Prepare Your Local Repository

```bash
# Ensure your code is pushed to GitHub
git add .
git commit -m "Prepare for Fortrabbit deployment"
git push origin main
```

## Step 3: Connect Fortrabbit to GitHub

1. In Fortrabbit dashboard, create a new App
2. Choose "Deploy from Git" 
3. Connect your GitHub repository
4. Select the branch to deploy (main)

## Step 4: Configure Environment Variables

In Fortrabbit dashboard, add these environment variables:

```
APP_NAME="JubbaStay"
APP_ENV=production
APP_KEY=base64:iWqUnFbvh6rnZP5GZiLqyovBLI0pEEo+rq84Lnfp3L0=
APP_DEBUG=false
APP_URL=https://YOUR-APP-NAME.fortrabbit.com

DB_CONNECTION=mysql
DB_HOST=your-mysql-host
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync

MAIL_MAILER=log
```

**Important:** Replace `YOUR-APP-NAME` with your actual app name from Fortrabbit dashboard!

## Step 5: Database Setup

1. In Fortrabbit dashboard, create a MySQL database
2. Copy the connection details to your environment variables
3. Run migrations automatically by adding post-deploy command:

```
php artisan migrate --force
```

## Step 6: Create Admin User

After first deploy, SSH into your Fortrabbit app and create an admin:

```bash
php artisan tinker
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('your-password'),
    'is_admin' => true,
]);
```

## Step 7: Build Frontend Assets

Fortrabbit will automatically run:
```bash
npm install
npm run build
```

## Step 8: Set Up Your Domain (IMPORTANT!)

**To access your app on the internet, you MUST configure a domain:**

### Option A: Use Fortrabbit Subdomain (Free)
1. Go to your App settings in Fortrabbit dashboard
2. Look for "Domains" or "HTTPS"
3. Your app URL is: `https://YOUR-APP-NAME.fortrabbit.com`
4. This is automatically enabled when you deploy

### Option B: Use Custom Domain
1. Go to your App settings → Domains
2. Add your custom domain (e.g., `www.jubbastay.com`)
3. Update your DNS records:
   - Create a CNAME record pointing to your Fortrabbit app
   - Example: `www` → `YOUR-APP-NAME.fortrabbit.com`

## Step 9: Visit Your App

Your app will be available at: `https://YOUR-APP-NAME.fortrabbit.com`

---

## 🔧 Troubleshooting

### "Cannot Access on Internet" - Solutions:

1. **Check if app URL is set correctly**
   - Go to Fortrabbit Dashboard → Your App
   - Look for the "URL" or "App URL" - it should show your live URL
   
2. **Verify APP_URL environment variable**
   - Make sure `APP_URL=https://YOUR-APP-NAME.fortrabbit.com` is set
   
3. **Check DNS if using custom domain**
   - CNAME must point to `YOUR-APP-NAME.fortrabbit.com`
   - DNS propagation can take up to 24 hours

4. **Check for 500 errors**
   - Run: `php artisan config:cache`
   - Check logs in Fortrabbit dashboard

### Common Issues:

1. **Database Connection Error**
   - Verify MySQL credentials in environment variables
   - Check if database is created in Fortrabbit dashboard

2. **Build Failures**
   - Check Node.js version compatibility
   - Run `npm run build` locally first to test

3. **500 Error After Deploy**
   - Verify APP_KEY is set (use the one from your .env file)
   - Check Fortrabbit logs in dashboard

### Useful Commands:

```bash
# SSH into Fortrabbit
ssh deploy@your-app.fortrabbit.com

# View logs
tail -f storage/logs/laravel.log

# Run artisan commands
php artisan migrate --force
php artisan cache:clear
php artisan config:cache
```

---

## Fortrabbit Pricing

- **Free Tier**: Limited (no MySQL)
- **Starter Plan**: ~$5/month (includes MySQL) - RECOMMENDED
- **Pro Plan**: ~$12/month (better performance)

Visit https://www.fortrabbit.com/pricing for details.
