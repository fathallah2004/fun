# Step-by-Step Guide: Run with `php artisan serve`

## Prerequisites Checklist

Before starting, you need:
- [ ] PHP 8.1 or higher
- [ ] Composer
- [ ] Node.js and npm

---

## STEP 1: Install PHP

### Option A: Install XAMPP (Easiest - Recommended)

1. **Download XAMPP:**
   - Go to: https://www.apachefriends.org/download.html
   - Download PHP 8.1+ version for Windows
   - File size: ~150MB

2. **Install XAMPP:**
   - Run the installer
   - Install to: `C:\xampp` (default)
   - Select PHP component (it's included by default)

3. **Add PHP to PATH:**
   - Open PowerShell as **Administrator**
   - Run this command:
   ```powershell
   [Environment]::SetEnvironmentVariable("Path", $env:Path + ";C:\xampp\php", "User")
   ```
   - **Close and reopen** your terminal/PowerShell

4. **Verify PHP is installed:**
   ```powershell
   php -v
   ```
   You should see PHP version information.

### Option B: Install PHP Only

1. Download from: https://windows.php.net/download/
2. Extract to `C:\php`
3. Add `C:\php` to your system PATH
4. Copy `php.ini-development` to `php.ini`
5. Uncomment: `extension_dir = "ext"` and required extensions

---

## STEP 2: Install Composer

1. **Download Composer:**
   - Go to: https://getcomposer.org/download/
   - Download "Composer-Setup.exe" (Windows installer)

2. **Install Composer:**
   - Run the installer
   - It will detect your PHP installation automatically
   - Complete the installation

3. **Verify Composer:**
   ```powershell
   composer --version
   ```

---

## STEP 3: Install Node.js

1. **Download Node.js:**
   - Go to: https://nodejs.org/
   - Download LTS version (recommended)
   - File size: ~30MB

2. **Install Node.js:**
   - Run the installer
   - Use default settings
   - npm comes included

3. **Verify Node.js:**
   ```powershell
   node -v
   npm -v
   ```

---

## STEP 4: Navigate to Project Folder

Open PowerShell or Command Prompt and go to your project:

```powershell
cd "C:\Users\fatha\OneDrive\Desktop\page"
```

---

## STEP 5: Install PHP Dependencies

```powershell
composer install
```

This will download all Laravel and PHP packages. Wait for it to complete (may take a few minutes).

---

## STEP 6: Install Node Dependencies

```powershell
npm install
```

This will download TailwindCSS, Vite, and other frontend packages.

---

## STEP 7: Create Environment File

```powershell
# Check if .env exists, if not create it
if (-not (Test-Path ".env")) {
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
}
```

Or manually create `.env` file with the content above.

---

## STEP 8: Generate Application Key

```powershell
php artisan key:generate
```

This creates a unique encryption key for your application.

---

## STEP 9: Create SQLite Database

```powershell
New-Item -Path database\database.sqlite -ItemType File -Force
```

---

## STEP 10: Run Database Migrations

```powershell
php artisan migrate
```

This creates all the database tables:
- login_attempts
- folders
- media
- sessions
- cache
- jobs

---

## STEP 11: Seed Database (Import Media)

```powershell
php artisan db:seed
```

This imports all media files from folders 1-21 into the database.

---

## STEP 12: Create Storage Link

```powershell
php artisan storage:link
```

This creates a symbolic link so media files can be accessed via the web.

---

## STEP 13: Build Frontend Assets

```powershell
npm run build
```

This compiles TailwindCSS and JavaScript files.

---

## STEP 14: Start the Server

```powershell
php artisan serve
```

You should see:
```
INFO  Server running on [http://127.0.0.1:8000].
```

---

## STEP 15: Open in Browser

Open your web browser and go to:
```
http://localhost:8000
```

---

## Quick Reference: All Commands in Order

```powershell
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
# (Create .env file manually or use the script above)
php artisan key:generate

# 3. Setup database
New-Item -Path database\database.sqlite -ItemType File -Force
php artisan migrate
php artisan db:seed
php artisan storage:link

# 4. Build assets
npm run build

# 5. Start server
php artisan serve
```

---

## Troubleshooting

### "php is not recognized"
- PHP is not installed or not in PATH
- Install XAMPP or add PHP to PATH
- Or use full path: `C:\xampp\php\php.exe artisan serve`

### "composer is not recognized"
- Install Composer from https://getcomposer.org/
- Or use: `php composer.phar install`

### "node is not recognized"
- Install Node.js from https://nodejs.org/
- Restart terminal after installation

### "Database file not found"
```powershell
New-Item -Path database\database.sqlite -ItemType File -Force
php artisan migrate
```

### "Styles not loading"
```powershell
npm run build
```

### "Storage link failed"
```powershell
php artisan storage:link
```

---

## After First Setup

Once everything is set up, you only need to run:

```powershell
php artisan serve
```

The server will start and you can access the application at http://localhost:8000

---

## Development Mode (Optional)

For development with hot reload:

**Terminal 1:**
```powershell
npm run dev
```

**Terminal 2:**
```powershell
php artisan serve
```

This allows CSS/JS changes to reload automatically.

---

## Stop the Server

Press `Ctrl + C` in the terminal where the server is running.
