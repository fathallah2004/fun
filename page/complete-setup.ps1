# Complete Setup Script - Finds and uses installed tools

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Complete Laravel Setup" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Find PHP
Write-Host "Looking for PHP..." -ForegroundColor Yellow
$phpPath = $null

# Check common locations
$phpLocations = @(
    "C:\xampp\php\php.exe",
    "C:\php\php.exe",
    "C:\wamp\bin\php\php*\php.exe",
    "C:\laragon\bin\php\php*\php.exe"
)

foreach ($location in $phpLocations) {
    $found = Get-ChildItem -Path (Split-Path $location -Parent) -Filter "php.exe" -ErrorAction SilentlyContinue | Select-Object -First 1
    if ($found) {
        $phpPath = $found.FullName
        Write-Host "✓ Found PHP at: $phpPath" -ForegroundColor Green
        break
    }
}

# Try PATH
if (-not $phpPath) {
    $phpCheck = Get-Command php -ErrorAction SilentlyContinue
    if ($phpCheck) {
        $phpPath = "php"
        Write-Host "✓ Found PHP in PATH" -ForegroundColor Green
    }
}

if (-not $phpPath) {
    Write-Host "✗ PHP not found!" -ForegroundColor Red
    Write-Host "  Please install XAMPP or add PHP to PATH" -ForegroundColor Yellow
    Write-Host "  Or tell me where PHP is installed" -ForegroundColor Yellow
    exit 1
}

# Find Composer
Write-Host ""
Write-Host "Looking for Composer..." -ForegroundColor Yellow
$composerPath = $null

$composerLocations = @(
    "C:\ProgramData\ComposerSetup\bin\composer.bat",
    "C:\Program Files\Composer\composer.bat",
    "composer.phar"
)

foreach ($location in $composerLocations) {
    if (Test-Path $location) {
        $composerPath = $location
        Write-Host "✓ Found Composer at: $composerPath" -ForegroundColor Green
        break
    }
}

# Try PATH
if (-not $composerPath) {
    $composerCheck = Get-Command composer -ErrorAction SilentlyContinue
    if ($composerCheck) {
        $composerPath = "composer"
        Write-Host "✓ Found Composer in PATH" -ForegroundColor Green
    }
}

if (-not $composerPath) {
    Write-Host "⚠ Composer not found, will try to download composer.phar" -ForegroundColor Yellow
    $composerPath = "composer.phar"
}

# Find Node
Write-Host ""
Write-Host "Looking for Node.js..." -ForegroundColor Yellow
$nodePath = $null

$nodeLocations = @(
    "C:\Program Files\nodejs\node.exe",
    "C:\Program Files (x86)\nodejs\node.exe"
)

foreach ($location in $nodeLocations) {
    if (Test-Path $location) {
        $nodePath = $location
        Write-Host "✓ Found Node.js at: $nodePath" -ForegroundColor Green
        break
    }
}

# Try PATH
if (-not $nodePath) {
    $nodeCheck = Get-Command node -ErrorAction SilentlyContinue
    if ($nodeCheck) {
        $nodePath = "node"
        Write-Host "✓ Found Node.js in PATH" -ForegroundColor Green
    }
}

if (-not $nodePath) {
    Write-Host "✗ Node.js not found!" -ForegroundColor Red
    Write-Host "  Please install Node.js or add to PATH" -ForegroundColor Yellow
    exit 1
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "Starting Setup..." -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

# Step 1: Install PHP dependencies
Write-Host "Step 1: Installing PHP dependencies..." -ForegroundColor Cyan
if ($composerPath -eq "composer.phar" -and -not (Test-Path "composer.phar")) {
    Write-Host "Downloading Composer..." -ForegroundColor Yellow
    Invoke-WebRequest -Uri "https://getcomposer.org/download/latest-stable/composer.phar" -OutFile "composer.phar"
}

if ($composerPath -like "*.bat") {
    & $composerPath install
} elseif ($composerPath -like "*.phar") {
    & $phpPath $composerPath install
} else {
    & $composerPath install
}

if ($LASTEXITCODE -ne 0) {
    Write-Host "✗ Failed to install PHP dependencies" -ForegroundColor Red
    exit 1
}
Write-Host "✓ PHP dependencies installed" -ForegroundColor Green

# Step 2: Install Node dependencies
Write-Host ""
Write-Host "Step 2: Installing Node dependencies..." -ForegroundColor Cyan
& $nodePath (Get-Command npm -ErrorAction SilentlyContinue | Select-Object -ExpandProperty Source) install
if ($LASTEXITCODE -ne 0) {
    # Try just npm
    npm install
}
if ($LASTEXITCODE -ne 0) {
    Write-Host "✗ Failed to install Node dependencies" -ForegroundColor Red
    exit 1
}
Write-Host "✓ Node dependencies installed" -ForegroundColor Green

# Step 3: Generate app key
Write-Host ""
Write-Host "Step 3: Generating application key..." -ForegroundColor Cyan
& $phpPath artisan key:generate --force
if ($LASTEXITCODE -ne 0) {
    Write-Host "⚠ Failed to generate key, but continuing..." -ForegroundColor Yellow
} else {
    Write-Host "✓ Application key generated" -ForegroundColor Green
}

# Step 4: Run migrations
Write-Host ""
Write-Host "Step 4: Running database migrations..." -ForegroundColor Cyan
& $phpPath artisan migrate --force
if ($LASTEXITCODE -ne 0) {
    Write-Host "✗ Failed to run migrations" -ForegroundColor Red
    exit 1
}
Write-Host "✓ Migrations completed" -ForegroundColor Green

# Step 5: Seed database
Write-Host ""
Write-Host "Step 5: Seeding database (importing media)..." -ForegroundColor Cyan
& $phpPath artisan db:seed --force
if ($LASTEXITCODE -ne 0) {
    Write-Host "⚠ Failed to seed database, but continuing..." -ForegroundColor Yellow
} else {
    Write-Host "✓ Database seeded" -ForegroundColor Green
}

# Step 6: Create storage link
Write-Host ""
Write-Host "Step 6: Creating storage link..." -ForegroundColor Cyan
& $phpPath artisan storage:link
if ($LASTEXITCODE -ne 0) {
    Write-Host "⚠ Failed to create storage link, but continuing..." -ForegroundColor Yellow
} else {
    Write-Host "✓ Storage link created" -ForegroundColor Green
}

# Step 7: Build frontend
Write-Host ""
Write-Host "Step 7: Building frontend assets..." -ForegroundColor Cyan
npm run build
if ($LASTEXITCODE -ne 0) {
    Write-Host "⚠ Failed to build assets, but continuing..." -ForegroundColor Yellow
} else {
    Write-Host "✓ Frontend assets built" -ForegroundColor Green
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

# Step 8: Start server
& $phpPath artisan serve
