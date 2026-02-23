@echo off
echo ================================================
echo BiteSpot Backend Setup
echo ================================================
echo.

echo Step 1: Installing Composer dependencies...
call composer install --no-interaction
if errorlevel 1 (
    echo Error: Composer install failed
    pause
    exit /b 1
)
echo ✓ Dependencies installed
echo.

echo Step 2: Generating application key...
php artisan key:generate --force
if errorlevel 1 (
    echo Error: Key generation failed
    pause
    exit /b 1
)
echo ✓ Application key generated
echo.

echo Step 3: Please configure your database in .env file
echo Default settings:
echo - DB_DATABASE=bitespot
echo - DB_USERNAME=root
echo - DB_PASSWORD=
echo.
pause

echo Step 4: Running migrations...
php artisan migrate --force
if errorlevel 1 (
    echo Error: Migration failed
    echo Please check your database configuration in .env
    pause
    exit /b 1
)
echo ✓ Migrations completed
echo.

echo Step 5: Seeding database with sample data...
php artisan db:seed --force
if errorlevel 1 (
    echo Error: Seeding failed
    pause
    exit /b 1
)
echo ✓ Database seeded
echo.

echo ================================================
echo Setup Complete!
echo ================================================
echo.
echo To start the development server, run:
echo php artisan serve
echo.
echo API will be available at: http://localhost:8000
echo.
pause
