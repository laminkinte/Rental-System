@echo off
cd /d "c:\xampp\htdocs\Rental Sytem"
echo Running Laravel checks...
echo.
echo === ROUTE LIST ===
php artisan route:list
echo.
echo === CONFIG CLEAR ===
php artisan config:clear
echo.
echo === CACHE CLEAR ===
php artisan cache:clear
echo.
echo === VIEW CACHE ===
php artisan view:cache
echo.
echo Done!
pause
