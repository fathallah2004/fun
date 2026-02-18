# Quick Start Guide

## If You Have PHP, Composer, and Node.js Installed

### Windows PowerShell - Run These Commands:

```powershell
# 1. Install dependencies
composer install
npm install

# 2. Create database
New-Item -Path database\database.sqlite -ItemType File -Force

# 3. Setup Laravel
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link

# 4. Build assets
npm run build

# 5. Start server
php artisan serve
```

Then open: **http://localhost:8000**

---

## If You DON'T Have PHP/Composer/Node.js

### Option 1: Use the Batch Script
Double-click `run.bat` - it will check and guide you through setup.

### Option 2: Install Prerequisites

1. **Install XAMPP** (includes PHP):
   - Download: https://www.apachefriends.org/
   - Install and add PHP to PATH: `C:\xampp\php`

2. **Install Composer**:
   - Download: https://getcomposer.org/download/
   - Run Windows installer

3. **Install Node.js**:
   - Download: https://nodejs.org/
   - Install LTS version

4. **Restart your terminal** and run the commands above.

---

## Using XAMPP (Alternative)

If you have XAMPP installed:

1. Copy project to `C:\xampp\htdocs\page`
2. Open XAMPP Control Panel
3. Start Apache
4. In terminal, navigate to project:
   ```powershell
   cd C:\xampp\htdocs\page
   ```
5. Use XAMPP's PHP:
   ```powershell
   C:\xampp\php\php.exe artisan serve
   ```

---

## What You'll See

1. **Landing Page**: Video background asking "Who are you?"
2. **Enter Name**: Type "Amine" or "Yasmine"
3. **Enter Email**: 
   - Amine: `fathallahamine2004@gmail.com`
   - Yasmine: `benharizyasmin@gmail.com`
4. **For Yasmine**: Answer "Who is your best person?" (answer: "you" or "amine")
5. **Presentation**: Beautiful cinematic gallery of memories

---

## Need Help?

- Check `HOW_TO_RUN.md` for detailed instructions
- Check `SETUP.md` for configuration details
- Check `PROJECT_STRUCTURE.md` for architecture overview
