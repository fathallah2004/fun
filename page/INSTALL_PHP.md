# How to Install PHP on Windows

## Option 1: Install XAMPP (Easiest - Recommended)

XAMPP includes PHP, MySQL, and Apache - everything you need!

1. **Download XAMPP:**
   - Go to: https://www.apachefriends.org/download.html
   - Download the PHP 8.1+ version for Windows
   - File size: ~150MB

2. **Install XAMPP:**
   - Run the installer
   - Install to default location: `C:\xampp`
   - During installation, you can choose which components to install (PHP is required)

3. **Add PHP to PATH:**
   - Open PowerShell as Administrator
   - Run this command:
   ```powershell
   [Environment]::SetEnvironmentVariable("Path", $env:Path + ";C:\xampp\php", "User")
   ```
   - **OR** manually:
     - Press `Win + R`, type `sysdm.cpl`, press Enter
     - Go to "Advanced" tab → "Environment Variables"
     - Under "User variables", find "Path" and click "Edit"
     - Click "New" and add: `C:\xampp\php`
     - Click OK on all dialogs

4. **Restart your terminal** and test:
   ```powershell
   php -v
   ```

---

## Option 2: Install PHP Only (Lighter)

1. **Download PHP:**
   - Go to: https://windows.php.net/download/
   - Download "VS16 x64 Non Thread Safe" ZIP file (latest PHP 8.1+)
   - Extract to: `C:\php`

2. **Add PHP to PATH:**
   - Press `Win + R`, type `sysdm.cpl`, press Enter
   - Go to "Advanced" tab → "Environment Variables"
   - Under "User variables", find "Path" and click "Edit"
   - Click "New" and add: `C:\php`
     - Click OK on all dialogs

3. **Configure PHP:**
   - In `C:\php`, copy `php.ini-development` to `php.ini`
   - Open `php.ini` and uncomment these lines (remove the `;`):
     ```
     extension_dir = "ext"
     extension=openssl
     extension=mbstring
     extension=curl
     ```

4. **Restart your terminal** and test:
   ```powershell
   php -v
   ```

---

## Option 3: Use Full Path (Temporary Solution)

If you install XAMPP but don't want to add to PATH, you can use the full path:

```powershell
C:\xampp\php\php.exe artisan serve
```

---

## After Installing PHP

Once PHP is installed and in your PATH, come back to the project folder and run:

```powershell
# Install dependencies
composer install
npm install

# Setup database
New-Item -Path database\database.sqlite -ItemType File -Force
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link

# Build assets
npm run build

# Start server
php artisan serve
```

---

## Quick Check Commands

After installation, verify everything works:

```powershell
php -v              # Should show PHP version
composer --version  # Should show Composer version (if installed)
node -v             # Should show Node.js version (if installed)
```

---

## Need Help?

- **XAMPP Issues:** Check https://www.apachefriends.org/faq.html
- **PHP Issues:** Check https://windows.php.net/
- **Composer:** Install from https://getcomposer.org/download/
