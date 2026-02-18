# Cinematic Souvenir Website

A private, cinematic, emotionally immersive souvenir website built with Laravel.

## Setup Instructions

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment Configuration**
   - Copy `.env.example` to `.env` (if not already done)
   - Generate application key: `php artisan key:generate`
   - Configure database (SQLite is already set up)
   - Configure mail settings in `.env`

3. **Create Database**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   php artisan db:seed
   ```

4. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

5. **Build Assets**
   ```bash
   npm run build
   # Or for development:
   npm run dev
   ```

6. **Start Server**
   ```bash
   php artisan serve
   ```

## Features

- Private authentication for two users (Amine and Yasmine)
- Cinematic landing page with video background
- Email verification system
- Login attempt logging and email notifications
- Multiple creative folder layouts
- Fullscreen gallery with filters
- Responsive design
- Smooth animations and transitions

## Valid Users

- **Amine**: fathallahamine2004@gmail.com
- **Yasmine**: benharizyasmin@gmail.com

## Notes

- Make sure to configure your mail settings in `.env` for email notifications
- Media files should be placed in the numbered folders (1-21) in the public directory
- The seeder will automatically import media from these folders
