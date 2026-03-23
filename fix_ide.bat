@echo off
cd /d "c:\xampp\htdocs\Rental Sytem"
echo ====================================
echo Fixing IDE/IntelliSense Issues
echo ====================================
echo.
echo 1. Clearing Composer autoload cache...
composer dump-autoload
echo.
echo 2. Clearing Laravel caches...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo.
echo 3. Optimizing Laravel...
php artisan optimize:clear
php artisan optimize
echo.
echo ====================================
echo Done! If red marks persist, try:
echo 1. Restarting VS Code
echo 2. Reloading the PHP IntelliSense extension
echo 3. Check Problems panel (Ctrl+Shift+M)
echo ====================================
pause
