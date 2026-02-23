@echo off
echo Starting BiteSpot with Laravel...
echo.

echo Starting Frontend Server on http://localhost:3000
start cmd /k "cd /d "%~dp0" && php -S localhost:3000"

timeout /t 2 /nobreak >nul

echo Starting Laravel Backend on http://localhost:8000
start cmd /k "cd /d "%~dp0backend" && php artisan serve"

timeout /t 3 /nobreak >nul

echo.
echo ================================================
echo  BiteSpot Laravel is Running!
echo ================================================
echo  Frontend:    http://localhost:3000/index.html
echo  Backend API: http://localhost:8000/api/restaurants
echo  API Health:  http://localhost:8000/api/health
echo ================================================
echo.

start chrome "http://localhost:3000/index.html"

echo Press any key to stop servers...
pause >nul
