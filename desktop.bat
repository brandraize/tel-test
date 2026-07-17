@echo off
title Materials Management Desktop

echo Checking for PHP...
php -v >nul 2>&1
if errorlevel 1 (
    echo PHP is not installed! Please install PHP.
    pause
    exit
)

echo Starting Materials Management...

start /B php artisan serve --host=127.0.0.1 --port=8000

timeout /t 3 /nobreak >nul

start http://127.0.0.1:8000

echo Application is running!
echo Press any key to close the server...
pause >nul

taskkill /F /IM php.exe /FI "WINDOWTITLE eq Materials Management*"
