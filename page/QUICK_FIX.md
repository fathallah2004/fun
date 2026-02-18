# Quick Fix: PHP Not Found

## Immediate Solution

If you have XAMPP installed, use this batch file:
- **Double-click:** `run-with-xampp.bat`

This will use XAMPP's PHP directly without needing to add it to PATH.

---

## If You Don't Have PHP Installed

### Fastest Way: Install XAMPP

1. **Download:** https://www.apachefriends.org/download.html
2. **Install** to `C:\xampp` (default)
3. **Run:** `run-with-xampp.bat` (no PATH setup needed!)

---

## After Installing XAMPP

You have two options:

### Option A: Use the Batch File (No PATH setup)
Just double-click `run-with-xampp.bat` whenever you want to run the server.

### Option B: Add to PATH (Use `php` command directly)
1. Open PowerShell as Administrator
2. Run:
   ```powershell
   [Environment]::SetEnvironmentVariable("Path", $env:Path + ";C:\xampp\php", "User")
   ```
3. Restart terminal
4. Now you can use: `php artisan serve`

---

## Full Setup After Installing PHP

Once PHP is available (via XAMPP or direct install), run these commands:

```powershell
# If using XAMPP, use full path:
C:\xampp\php\php.exe -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
C:\xampp\php\php.exe composer-setup.php
C:\xampp\php\php.exe composer.phar install

# Install Node dependencies
npm install

# Setup Laravel
C:\xampp\php\php.exe artisan key:generate
New-Item -Path database\database.sqlite -ItemType File -Force
C:\xampp\php\php.exe artisan migrate
C:\xampp\php\php.exe artisan db:seed
C:\xampp\php\php.exe artisan storage:link

# Build assets
npm run build

# Start server
C:\xampp\php\php.exe artisan serve
```

Or use the batch file: `run-with-xampp.bat`
