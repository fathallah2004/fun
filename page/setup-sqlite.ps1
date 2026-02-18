# PowerShell script to setup SQLite database

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "SQLite Database Setup" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Check if .env exists
Write-Host "Checking .env file..." -ForegroundColor Yellow
if (-not (Test-Path ".env")) {
    Write-Host "Creating .env file..." -ForegroundColor Yellow
    if (Test-Path ".env.example") {
        Copy-Item ".env.example" ".env"
        Write-Host "✓ .env file created from .env.example" -ForegroundColor Green
    } else {
        Write-Host "⚠ .env.example not found, creating basic .env..." -ForegroundColor Yellow
        @"
APP_NAME="Cinematic Souvenir"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
"@ | Out-File -FilePath ".env" -Encoding utf8
        Write-Host "✓ Basic .env file created" -ForegroundColor Green
    }
} else {
    Write-Host "✓ .env file already exists" -ForegroundColor Green
}

# Check PHP
Write-Host ""
Write-Host "Checking PHP..." -ForegroundColor Yellow
$phpPath = $null
$phpCheck = Get-Command php -ErrorAction SilentlyContinue
if ($phpCheck) {
    $phpPath = "php"
    Write-Host "✓ PHP found in PATH" -ForegroundColor Green
} elseif (Test-Path "C:\xampp\php\php.exe") {
    $phpPath = "C:\xampp\php\php.exe"
    Write-Host "✓ PHP found at C:\xampp\php\php.exe" -ForegroundColor Green
} elseif (Test-Path "C:\php\php.exe") {
    $phpPath = "C:\php\php.exe"
    Write-Host "✓ PHP found at C:\php\php.exe" -ForegroundColor Green
} else {
    Write-Host "✗ PHP not found!" -ForegroundColor Red
    Write-Host "  Please install PHP or XAMPP first" -ForegroundColor Yellow
    Write-Host "  See INSTALL_PHP.md for instructions" -ForegroundColor Yellow
    exit 1
}

# Create database directory if it doesn't exist
Write-Host ""
Write-Host "Checking database directory..." -ForegroundColor Yellow
if (-not (Test-Path "database")) {
    New-Item -Path "database" -ItemType Directory | Out-Null
    Write-Host "✓ Database directory created" -ForegroundColor Green
} else {
    Write-Host "✓ Database directory exists" -ForegroundColor Green
}

# Create SQLite database file
Write-Host ""
Write-Host "Creating SQLite database..." -ForegroundColor Yellow
if (-not (Test-Path "database\database.sqlite")) {
    New-Item -Path "database\database.sqlite" -ItemType File -Force | Out-Null
    Write-Host "✓ SQLite database file created" -ForegroundColor Green
} else {
    Write-Host "✓ SQLite database file already exists" -ForegroundColor Green
    $overwrite = Read-Host "Do you want to recreate it? (y/N)"
    if ($overwrite -eq "y" -or $overwrite -eq "Y") {
        Remove-Item "database\database.sqlite" -Force
        New-Item -Path "database\database.sqlite" -ItemType File -Force | Out-Null
        Write-Host "✓ Database recreated" -ForegroundColor Green
    }
}

# Generate app key if needed
Write-Host ""
Write-Host "Generating application key..." -ForegroundColor Yellow
& $phpPath artisan key:generate --force
if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Application key generated" -ForegroundColor Green
} else {
    Write-Host "⚠ Failed to generate key, but continuing..." -ForegroundColor Yellow
}

# Run migrations
Write-Host ""
Write-Host "Running database migrations..." -ForegroundColor Yellow
& $phpPath artisan migrate --force
if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Migrations completed successfully" -ForegroundColor Green
} else {
    Write-Host "✗ Migrations failed" -ForegroundColor Red
    exit 1
}

# Ask about seeding
Write-Host ""
$seed = Read-Host "Do you want to seed the database (import media from folders 1-21)? (Y/n)"
if ($seed -ne "n" -and $seed -ne "N") {
    Write-Host "Seeding database..." -ForegroundColor Yellow
    & $phpPath artisan db:seed --force
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ Database seeded successfully" -ForegroundColor Green
    } else {
        Write-Host "⚠ Seeding failed, but continuing..." -ForegroundColor Yellow
    }
}

# Create storage link
Write-Host ""
Write-Host "Creating storage link..." -ForegroundColor Yellow
& $phpPath artisan storage:link
if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Storage link created" -ForegroundColor Green
} else {
    Write-Host "⚠ Failed to create storage link, but continuing..." -ForegroundColor Yellow
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "SQLite Setup Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Database location: database\database.sqlite" -ForegroundColor Cyan
Write-Host ""
Write-Host "To view the database, use:" -ForegroundColor Yellow
Write-Host "  - DB Browser for SQLite: https://sqlitebrowser.org/" -ForegroundColor Gray
Write-Host "  - Laravel Tinker: $phpPath artisan tinker" -ForegroundColor Gray
Write-Host ""
