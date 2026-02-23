@echo off
echo ================================================
echo BiteSpot Database Setup and Verification
echo ================================================
echo.

cd /d "d:\Projects\Web project\food hub\backend"

echo Step 1: Generating application key...
php artisan key:generate
echo.

echo Step 2: Running migrations (creating tables)...
php artisan migrate --force
echo.

echo Step 3: Seeding database with sample data...
php artisan db:seed --force
echo.

echo ================================================
echo Database setup complete!
echo ================================================
echo.

echo Checking database tables...
mysql -u root bitespot -e "SHOW TABLES;"
echo.

echo Restaurants in database:
mysql -u root bitespot -e "SELECT id, name, rating FROM restaurants;"
echo.

echo Menu items count:
mysql -u root bitespot -e "SELECT COUNT(*) as total_items FROM menu_items;"
echo.

echo ================================================
echo Database is ready! Press any key to continue...
pause >nul
