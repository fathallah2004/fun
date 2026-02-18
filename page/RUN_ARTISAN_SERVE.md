# Running with `php artisan serve`

## Prerequisites Check

Before running `php artisan serve`, you need:

1. **PHP 8.1+** installed and in PATH
2. **Composer** installed
3. **Node.js** installed (for frontend assets)

## Step-by-Step Setup

### Step 1: Install PHP Dependencies
```powershell
composer install
```

### Step 2: Install Node Dependencies
```powershell
npm install
```

### Step 3: Create .env File
```powershell
copy .env.example .env
```
(If .env.example doesn't exist, the .env file should already be there)

### Step 4: Generate Application Key
```powershell
php artisan key:generate
```

### Step 5: Create Database
```powershell
New-Item -Path database\database.sqlite -ItemType File -Force
```

### Step 6: Run Migrations
```powershell
php artisan migrate
```

### Step 7: Seed Database (Import Media)
```powershell
php artisan db:seed
```

### Step 8: Create Storage Link
```powershell
php artisan storage:link
```

### Step 9: Build Frontend Assets
```powershell
npm run build
```

### Step 10: Start Server
```powershell
php artisan serve
```

The server will start at: **http://localhost:8000**

---

## If PHP/Composer/Node are NOT in PATH

### Option 1: Add to PATH
Add these to your system PATH:
- PHP: Usually `C:\xampp\php` or `C:\php`
- Composer: Usually `C:\ProgramData\ComposerSetup\bin`
- Node: Usually `C:\Program Files\nodejs`

### Option 2: Use Full Paths
```powershell
# If PHP is in XAMPP
C:\xampp\php\php.exe artisan serve

# If Composer is not in PATH
php composer.phar install
```

---

## Quick One-Liner Setup (if everything is installed)

```powershell
composer install && npm install && New-Item -Path database\database.sqlite -ItemType File -Force && php artisan key:generate && php artisan migrate && php artisan db:seed && php artisan storage:link && npm run build && php artisan serve
```

---

## Troubleshooting

**"php is not recognized"**
- Install PHP or XAMPP
- Add PHP to system PATH
- Or use full path: `C:\xampp\php\php.exe artisan serve`

**"composer is not recognized"**
- Install Composer from https://getcomposer.org/
- Or download composer.phar and use: `php composer.phar install`

**"node is not recognized"**
- Install Node.js from https://nodejs.org/
- Restart terminal after installation

**Database errors**
- Make sure `database/database.sqlite` exists
- Run migrations: `php artisan migrate`

**Styles not loading**
- Build assets: `npm run build`
- Or run dev server: `npm run dev` (in separate terminal)
