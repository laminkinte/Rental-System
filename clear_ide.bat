@echo off
cd /d "c:\xampp\htdocs\Rental Sytem"
echo ====================================
echo Clearing IDE Cache and Re-indexing
echo ====================================
echo.
echo 1. Clearing composer autoload...
composer dump-autoload -o
echo.
echo 2. Clearing Laravel caches...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
echo.
echo 3. Re-optimizing...
php artisan optimize:clear
php artisan optimize
echo.
echo 4. Creating bootstrap cache...
php artisan about
echo.
echo ====================================
echo Done!
echo.
echo If red marks still appear:
echo 1. Close VS Code
echo 2. Delete .vscode folder if exists
echo 3. Reopen VS Code
echo 4. Wait for IntelliSense to re-index
echo ====================================
pause
