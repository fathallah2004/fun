# Setup Instructions

## Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and npm
- SQLite (usually included with PHP)

## Step-by-Step Setup

1. **Install PHP Dependencies**
   ```bash
   composer install
   ```

2. **Install Node Dependencies**
   ```bash
   npm install
   ```

3. **Create Environment File**
   - The `.env` file should already exist
   - Update mail settings if needed:
     ```
     MAIL_MAILER=smtp
     MAIL_HOST=smtp.gmail.com
     MAIL_PORT=587
     MAIL_USERNAME=your-email@gmail.com
     MAIL_PASSWORD=your-app-password
     MAIL_ENCRYPTION=tls
     MAIL_FROM_ADDRESS=fathallahamine2004@gmail.com
     ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Create Database**
   ```bash
   # Create SQLite database file
   touch database/database.sqlite
   
   # Or on Windows PowerShell:
   New-Item -Path database\database.sqlite -ItemType File
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed Database**
   ```bash
   php artisan db:seed
   ```
   This will import media from folders 1-21 in your project root.

8. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

9. **Build Assets**
   ```bash
   # For production
   npm run build
   
   # For development (with hot reload)
   npm run dev
   ```

10. **Start Development Server**
    ```bash
    php artisan serve
    ```

11. **Start Queue Worker (for email notifications)**
    ```bash
    php artisan queue:work
    ```

## Access the Application

- Landing page: `http://localhost:8000`
- Valid users:
  - **Amine**: fathallahamine2004@gmail.com
  - **Yasmine**: benharizyasmin@gmail.com

## Troubleshooting

- If media files don't show: Make sure `php artisan storage:link` was run
- If emails don't send: Check mail configuration in `.env` and ensure queue worker is running
- If styles don't load: Run `npm run build` or `npm run dev`
