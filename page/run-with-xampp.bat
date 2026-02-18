@echo off
echo ========================================
echo Running Laravel with XAMPP PHP
echo ========================================
echo.

REM Check if XAMPP PHP exists
if exist "C:\xampp\php\php.exe" (
    set PHP_PATH=C:\xampp\php\php.exe
    echo Found XAMPP PHP at C:\xampp\php\php.exe
) else if exist "C:\php\php.exe" (
    set PHP_PATH=C:\php\php.exe
    echo Found PHP at C:\php\php.exe
) else (
    echo ERROR: PHP not found!
    echo.
    echo Please install PHP:
    echo 1. Download XAMPP from https://www.apachefriends.org/
    echo 2. Or download PHP from https://windows.php.net/download/
    echo.
    echo See INSTALL_PHP.md for detailed instructions.
    pause
    exit /b 1
)

echo.
echo Starting Laravel development server...
echo Open http://localhost:8000 in your browser
echo.
echo Press Ctrl+C to stop the server
echo.

"%PHP_PATH%" artisan serve
