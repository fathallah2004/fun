# Working with SQLite in This Project

## ✅ Good News!

**Your application is already configured to use SQLite!** No MySQL, PostgreSQL, or other database server needed.

## SQLite Configuration

The application uses SQLite with these settings:
- **Database File:** `database/database.sqlite`
- **Connection:** Already set in `config/database.php`
- **Environment:** `.env` file has `DB_CONNECTION=sqlite`

## Setup SQLite Database

### Step 1: Create the Database File

```powershell
New-Item -Path database\database.sqlite -ItemType File -Force
```

### Step 2: Run Migrations

Once you have PHP installed, run:

```powershell
php artisan migrate
```

This will create all the tables:
- `login_attempts` - Stores login attempts
- `folders` - Stores folder information
- `media` - Stores media file references
- `sessions` - For session storage
- `cache` - For caching
- `jobs` - For queued jobs (emails)

### Step 3: Seed the Database

Import your media files from folders 1-21:

```powershell
php artisan db:seed
```

## Viewing SQLite Database

### Option 1: Using DB Browser for SQLite (Recommended)

1. **Download:** https://sqlitebrowser.org/
2. **Install** DB Browser for SQLite
3. **Open** the database file:
   - File → Open Database
   - Navigate to: `database/database.sqlite`

### Option 2: Using Command Line

If you have SQLite command-line tools:

```powershell
sqlite3 database\database.sqlite
```

Then you can run SQL commands:
```sql
.tables                    -- List all tables
SELECT * FROM folders;     -- View folders
SELECT * FROM media;        -- View media
SELECT * FROM login_attempts; -- View login attempts
.quit                      -- Exit
```

### Option 3: Using Laravel Tinker

```powershell
php artisan tinker
```

Then in tinker:
```php
// View all folders
\App\Models\Folder::all();

// View all media
\App\Models\Media::all();

// View login attempts
\App\Models\LoginAttempt::all();

// Count records
\App\Models\Folder::count();
\App\Models\Media::count();
```

## Database Structure

### folders Table
- `id` - Primary key
- `title` - Folder title
- `description` - Folder description
- `slug` - URL-friendly slug
- `layout_type` - Layout type (hero-split, masonry, etc.)
- `order` - Display order
- `created_at`, `updated_at` - Timestamps

### media Table
- `id` - Primary key
- `folder_id` - Foreign key to folders
- `type` - 'image' or 'video'
- `path` - Path to media file
- `caption` - Media caption
- `angle_style` - Styling information
- `order` - Display order
- `created_at`, `updated_at` - Timestamps

### login_attempts Table
- `id` - Primary key
- `entered_name` - Name entered
- `entered_email` - Email entered
- `ip_address` - IP address
- `browser` - Browser name
- `device_info` - Device information
- `user_agent` - Full user agent string
- `success` - Boolean (true/false)
- `created_at` - Timestamp

## Common SQLite Operations

### Reset Database (Delete and Recreate)

```powershell
# Delete database
Remove-Item database\database.sqlite

# Recreate
New-Item -Path database\database.sqlite -ItemType File -Force

# Run migrations
php artisan migrate

# Seed data
php artisan db:seed
```

### Backup Database

```powershell
Copy-Item database\database.sqlite database\database_backup.sqlite
```

### View Database Size

```powershell
(Get-Item database\database.sqlite).Length
```

## Advantages of SQLite

✅ **No Server Required** - Just a file  
✅ **Easy to Backup** - Just copy the file  
✅ **Portable** - Move the file anywhere  
✅ **Fast** - Great for small to medium applications  
✅ **Zero Configuration** - Works out of the box  

## Important Notes

- The database file is located at: `database/database.sqlite`
- Make sure this file is writable by your web server
- Always backup before making major changes
- The database is automatically created when you run migrations

## Troubleshooting

### "Database file not found"
```powershell
New-Item -Path database\database.sqlite -ItemType File -Force
php artisan migrate
```

### "Database is locked"
- Close any programs viewing the database (DB Browser, etc.)
- Make sure no other process is using it

### "Permission denied"
- Check file permissions on `database/database.sqlite`
- Make sure the directory is writable
