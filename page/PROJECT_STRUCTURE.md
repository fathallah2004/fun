# Project Structure

## Key Features Implemented

### Authentication System
- Landing page with video background and glassmorphism input
- Name validation (only "Amine" or "Yasmine")
- Email verification with specific emails for each user
- Login attempt logging to database
- Email notifications (queued) sent to fathallahamine2004@gmail.com
- Rate limiting on login attempts
- Special "best person" question for Yasmine

### Dashboard
- **Amine**: Two buttons - "Send Notification" (opens modal) and "See Content"
- **Yasmine**: Automatically redirects to presentation

### Presentation System
- 9 different creative folder layouts:
  1. Hero Split - Large left image with stacked right images
  2. Masonry Grid - Pinterest-style grid layout
  3. Fullscreen Video - Video background with overlay text
  4. Polaroid - Tilted photo layout with rotations
  5. Circular - Circular masked images
  6. Diagonal - Sections rotated 2-3 degrees
  7. Horizontal Scroll - Horizontal scroll inside vertical flow
  8. Timeline - Timeline layout with alternating sides
  9. Overlapping - Overlapping layers with depth

### Animations & Effects
- IntersectionObserver for scroll-triggered animations
- Fade-in, slide, scale, blur-to-sharp, grayscale-to-color transitions
- Hover effects: zoom, shadow intensification, caption gradient overlays
- Autoplay muted looping videos that pause when out of viewport
- Smooth scrolling with optional snap scrolling
- Subtle parallax effects
- Glassmorphism overlays

### Gallery
- Fullscreen modal gallery
- Folder filters
- Hover video previews
- Signed URLs for media access

### Design
- Color palette: #fdf6ec (cream), #6a1e2c (burgundy), #c6a75e (gold), #222222 (charcoal)
- Typography: Playfair Display (headings) + Poppins (body)
- Responsive: Desktop (cinematic), Tablet (adjusted), Mobile (vertical adaptation)
- No header, no footer, full-screen experience

### Security
- Route protection via middleware
- CSRF protection
- Signed URLs for media
- Rate limiting
- Login attempt logging

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── NotificationController.php
│   │   └── PresentationController.php
│   └── Middleware/
│       ├── AuthenticateUser.php
│       ├── EncryptCookies.php
│       └── VerifyCsrfToken.php
├── Mail/
│   └── LoginAttemptNotification.php
├── Models/
│   ├── Folder.php
│   ├── LoginAttempt.php
│   └── Media.php
└── Services/
    └── LoginAttemptService.php

database/
├── migrations/
│   ├── create_login_attempts_table.php
│   ├── create_folders_table.php
│   ├── create_media_table.php
│   └── create_jobs_table.php
└── seeders/
    └── DatabaseSeeder.php

resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php
│   ├── presentation/
│   │   ├── index.blade.php
│   │   ├── gallery.blade.php
│   │   ├── components/
│   │   │   └── folder-layout.blade.php
│   │   └── layouts/
│   │       ├── hero-split.blade.php
│   │       ├── masonry.blade.php
│   │       ├── fullscreen-video.blade.php
│   │       ├── polaroid.blade.php
│   │       ├── circular.blade.php
│   │       ├── diagonal.blade.php
│   │       ├── horizontal-scroll.blade.php
│   │       ├── timeline.blade.php
│   │       └── overlapping.blade.php
│   ├── emails/
│   │   └── login-attempt.blade.php
│   ├── landing.blade.php
│   ├── best-person.blade.php
│   └── dashboard.blade.php
├── css/
│   └── app.css
└── js/
    ├── app.js
    └── bootstrap.js
```

## Database Schema

### login_attempts
- id
- entered_name
- entered_email
- ip_address
- browser
- device_info
- user_agent
- success (boolean)
- created_at

### folders
- id
- title
- description
- slug (unique)
- layout_type
- order
- timestamps

### media
- id
- folder_id (foreign key)
- type (image/video)
- path
- caption
- angle_style
- order
- timestamps

## Routes

- `GET /` - Landing page
- `POST /verify-name` - Verify name
- `POST /verify-email` - Verify email
- `GET /best-person` - Best person question (Yasmine only)
- `POST /verify-best-person` - Verify best person answer
- `GET /dashboard` - Dashboard (protected)
- `GET /presentation` - Presentation view (protected)
- `GET /gallery` - Full gallery (protected)
- `POST /send-notification` - Send email to Yasmine (protected)
