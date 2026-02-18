# How to Run the Application

## Prerequisites Installation

Before running the application, you need to install:

### 1. PHP (8.1 or higher)
- Download from: https://windows.php.net/download/
- Or install XAMPP (includes PHP, MySQL, Apache): https://www.apachefriends.org/
- Add PHP to your system PATH

### 2. Composer
- Download from: https://getcomposer.org/download/
- Run the Windows installer
- Or download `composer.phar` and use it directly

### 3. Node.js and npm
- Download from: https://nodejs.org/
- Install the LTS version
- npm comes included with Node.js

## Step-by-Step Setup

### Step 1: Install PHP Dependencies
```powershell
composer install
```

If composer is not in PATH, use:
```powershell
php composer.phar install
```

### Step 2: Install Node Dependencies
```powershell
npm install
```

### Step 3: Create Environment File
The `.env` file should already exist. If not, copy from `.env.example`:
```powershell
copy .env.example .env
```

### Step 4: Generate Application Key
```powershell
php artisan key:generate
```

### Step 5: Create SQLite Database
```powershell
New-Item -Path database\database.sqlite -ItemType File -Force
```

### Step 6: Run Database Migrations
```powershell
php artisan migrate
```

### Step 7: Seed Database (Import Media)
This will import all media files from folders 1-21:
```powershell
php artisan db:seed
```

### Step 8: Create Storage Link
```powershell
php artisan storage:link
```

### Step 9: Build Frontend Assets
For production:
```powershell
npm run build
```

For development (with hot reload):
```powershell
npm run dev
```

## Running the Application

### Option 1: Laravel Development Server (Recommended)
```powershell
php artisan serve
```
Then open: http://localhost:8000

### Option 2: With Queue Worker (For Email Notifications)
Open two terminal windows:

**Terminal 1:**
```powershell
php artisan serve
```

**Terminal 2:**
```powershell
php artisan queue:work
```

### Option 3: Using XAMPP/WAMP
1. Copy the project to `htdocs` or `www` folder
2. Configure virtual host pointing to `public` directory
3. Access via your configured domain

## Quick Start Script

If you have everything installed, run these commands in order:

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

## Troubleshooting

### PHP Not Found
- Make sure PHP is installed and added to PATH
- Or use full path: `C:\xampp\php\php.exe artisan serve`

### Composer Not Found
- Download composer.phar and use: `php composer.phar install`
- Or install Composer globally

### Node Not Found
- Install Node.js from nodejs.org
- Restart terminal after installation

### Database Errors
- Make sure `database/database.sqlite` file exists
- Check file permissions

### Storage Link Issues
- Run: `php artisan storage:link`
- If it fails, manually create symlink or copy files

### Styles Not Loading
- Run: `npm run build` or `npm run dev`
- Make sure Vite is running if using `npm run dev`

## Access the Application

Once running, visit:
- **Landing Page**: http://localhost:8000
- **Valid Users**:
  - Name: `Amine` → Email: `fathallahamine2004@gmail.com`
  - Name: `Yasmine` → Email: `benharizyasmin@gmail.com`

## Development Mode

For active development with hot reload:
```powershell
# Terminal 1: Vite dev server
npm run dev

# Terminal 2: Laravel server
php artisan serve

# Terminal 3: Queue worker (optional, for emails)
php artisan queue:work
```
