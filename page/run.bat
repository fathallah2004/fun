@echo off
echo ========================================
echo Cinematic Souvenir - Setup Script
echo ========================================
echo.

echo Checking PHP...
php --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: PHP is not installed or not in PATH
    echo Please install PHP 8.1+ or XAMPP
    pause
    exit /b 1
)

echo Checking Composer...
composer --version >nul 2>&1
if errorlevel 1 (
    echo WARNING: Composer not found, trying composer.phar...
    if not exist composer.phar (
        echo ERROR: Composer is not installed
        echo Please install Composer from https://getcomposer.org/
        pause
        exit /b 1
    )
    set COMPOSER=php composer.phar
) else (
    set COMPOSER=composer
)

echo Checking Node.js...
node --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Node.js is not installed
    echo Please install Node.js from https://nodejs.org/
    pause
    exit /b 1
)

echo.
echo Step 1: Installing PHP dependencies...
%COMPOSER% install
if errorlevel 1 (
    echo ERROR: Failed to install PHP dependencies
    pause
    exit /b 1
)

echo.
echo Step 2: Installing Node dependencies...
call npm install
if errorlevel 1 (
    echo ERROR: Failed to install Node dependencies
    pause
    exit /b 1
)

echo.
echo Step 3: Creating database file...
if not exist database\database.sqlite (
    New-Item -Path database\database.sqlite -ItemType File -Force >nul
    echo Database file created
) else (
    echo Database file already exists
)

echo.
echo Step 4: Generating application key...
php artisan key:generate
if errorlevel 1 (
    echo WARNING: Failed to generate key, but continuing...
)

echo.
echo Step 5: Running migrations...
php artisan migrate --force
if errorlevel 1 (
    echo ERROR: Failed to run migrations
    pause
    exit /b 1
)

echo.
echo Step 6: Seeding database (importing media)...
php artisan db:seed --force
if errorlevel 1 (
    echo WARNING: Failed to seed database, but continuing...
)

echo.
echo Step 7: Creating storage link...
php artisan storage:link
if errorlevel 1 (
    echo WARNING: Failed to create storage link, but continuing...
)

echo.
echo Step 8: Building frontend assets...
call npm run build
if errorlevel 1 (
    echo WARNING: Failed to build assets, but continuing...
)

echo.
echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo Starting Laravel development server...
echo Open http://localhost:8000 in your browser
echo.
echo Press Ctrl+C to stop the server
echo.

php artisan serve
