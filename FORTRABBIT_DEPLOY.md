# 🚀 Deploy to Fortrabbit

## Step 1: Create Fortrabbit Account

1. Go to https://www.fortrabbit.com
2. Sign up for an account
3. Create a new "App" with PHP/Laravel template

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
APP_KEY=  # Leave empty - Fortrabbit will generate it
APP_DEBUG=false
APP_URL=https://your-app.fortrabbit.com

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

## Step 5: Database Setup

1. In Fortrabbit dashboard, create a MySQL database
2. Copy the connection details to your environment variables
3. Run migrations:

```bash
php artisan migrate --force
```

## Step 6: Create Admin User

SSH into your Fortrabbit app and create an admin:

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

## Step 8: Visit Your App

Your app will be available at: `https://your-app-name.fortrabbit.com`

---

## Troubleshooting

### Common Issues:

1. **Database Connection Error**
   - Verify MySQL credentials in environment variables
   - Check if database is created in Fortrabbit dashboard

2. **Build Failures**
   - Check Node.js version compatibility
   - Run `npm run build` locally first to test

3. **500 Error After Deploy**
   - Check Fortrabbit logs: `tail -f storage/logs/laravel.log`
   - Verify APP_KEY is set

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
- **Starter Plan**: ~$5/month (includes MySQL)
- **Pro Plan**: ~$12/month (better performance)

Visit https://www.fortrabbit.com/pricing for details.
