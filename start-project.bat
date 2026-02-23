@echo off
echo Starting BiteSpot Project...
echo.

echo Starting Frontend Server on http://localhost:3000
start cmd /k "cd /d "%~dp0" && php -S localhost:3000"

timeout /t 2 /nobreak >nul

echo Starting Backend Server on http://localhost:8000
start cmd /k "cd /d "%~dp0backend" && php -S localhost:8000 -t public"

timeout /t 2 /nobreak >nul

echo.
echo ================================================
echo  BiteSpot is Running!
echo ================================================
echo  Frontend: http://localhost:3000/index.html
echo  Backend:  http://localhost:8000/api-test.php
echo ================================================
echo.

start chrome "http://localhost:3000/index.html"

echo Press any key to stop servers...
pause >nul
