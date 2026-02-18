# PowerShell script to setup and run Laravel with artisan serve

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Laravel Setup and Run Script" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Check PHP
Write-Host "Checking PHP..." -ForegroundColor Yellow
$phpCheck = Get-Command php -ErrorAction SilentlyContinue
if ($phpCheck) {
    $phpVersion = php -v 2>&1 | Select-Object -First 1
    Write-Host "✓ PHP found: $phpVersion" -ForegroundColor Green
} else {
    Write-Host "✗ PHP not found. Please install PHP or XAMPP" -ForegroundColor Red
    Write-Host "  Download: https://windows.php.net/download/" -ForegroundColor Yellow
    exit 1
}

# Check Composer
Write-Host "Checking Composer..." -ForegroundColor Yellow
$composerCmd = "composer"
$composerCheck = Get-Command composer -ErrorAction SilentlyContinue
if ($composerCheck) {
    $composerVersion = composer -v 2>&1 | Select-Object -First 1
    Write-Host "✓ Composer found: $composerVersion" -ForegroundColor Green
} else {
    if (Test-Path "composer.phar") {
        $composerCmd = "php composer.phar"
        Write-Host "✓ Using composer.phar" -ForegroundColor Green
    } else {
        Write-Host "✗ Composer not found. Please install Composer" -ForegroundColor Red
        Write-Host "  Download: https://getcomposer.org/download/" -ForegroundColor Yellow
        exit 1
    }
}

# Check Node
Write-Host "Checking Node.js..." -ForegroundColor Yellow
$nodeCheck = Get-Command node -ErrorAction SilentlyContinue
if ($nodeCheck) {
    $nodeVersion = node -v 2>&1
    Write-Host "✓ Node.js found: $nodeVersion" -ForegroundColor Green
} else {
    Write-Host "✗ Node.js not found. Please install Node.js" -ForegroundColor Red
    Write-Host "  Download: https://nodejs.org/" -ForegroundColor Yellow
    exit 1
}

Write-Host ""
Write-Host "Step 1: Installing PHP dependencies..." -ForegroundColor Cyan
& $composerCmd install
if ($LASTEXITCODE -ne 0) {
    Write-Host "✗ Failed to install PHP dependencies" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "Step 2: Installing Node dependencies..." -ForegroundColor Cyan
npm install
if ($LASTEXITCODE -ne 0) {
    Write-Host "✗ Failed to install Node dependencies" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "Step 3: Creating .env file..." -ForegroundColor Cyan
if (-not (Test-Path ".env")) {
    if (Test-Path ".env.example") {
        Copy-Item ".env.example" ".env"
        Write-Host "✓ .env file created" -ForegroundColor Green
    } else {
        Write-Host "⚠ .env.example not found, but continuing..." -ForegroundColor Yellow
    }
} else {
    Write-Host "✓ .env file already exists" -ForegroundColor Green
}

Write-Host ""
Write-Host "Step 4: Generating application key..." -ForegroundColor Cyan
php artisan key:generate --force
if ($LASTEXITCODE -ne 0) {
    Write-Host "⚠ Failed to generate key, but continuing..." -ForegroundColor Yellow
}

Write-Host ""
Write-Host "Step 5: Creating database..." -ForegroundColor Cyan
if (-not (Test-Path "database\database.sqlite")) {
    New-Item -Path "database\database.sqlite" -ItemType File -Force | Out-Null
    Write-Host "✓ Database file created" -ForegroundColor Green
} else {
    Write-Host "✓ Database file already exists" -ForegroundColor Green
}

Write-Host ""
Write-Host "Step 6: Running migrations..." -ForegroundColor Cyan
php artisan migrate --force
if ($LASTEXITCODE -ne 0) {
    Write-Host "✗ Failed to run migrations" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "Step 7: Seeding database..." -ForegroundColor Cyan
php artisan db:seed --force
if ($LASTEXITCODE -ne 0) {
    Write-Host "⚠ Failed to seed database, but continuing..." -ForegroundColor Yellow
}

Write-Host ""
Write-Host "Step 8: Creating storage link..." -ForegroundColor Cyan
php artisan storage:link
if ($LASTEXITCODE -ne 0) {
    Write-Host "⚠ Failed to create storage link, but continuing..." -ForegroundColor Yellow
}

Write-Host ""
Write-Host "Step 9: Building frontend assets..." -ForegroundColor Cyan
npm run build
if ($LASTEXITCODE -ne 0) {
    Write-Host "⚠ Failed to build assets, but continuing..." -ForegroundColor Yellow
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "Setup Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Starting Laravel development server..." -ForegroundColor Cyan
Write-Host "Open http://localhost:8000 in your browser" -ForegroundColor Yellow
Write-Host ""
Write-Host "Press Ctrl+C to stop the server" -ForegroundColor Gray
Write-Host ""

php artisan serve
