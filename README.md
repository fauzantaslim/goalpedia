# Goalpedia

A modern football content platform built with Laravel 12 and Filament 5. Goalpedia delivers football news, stats, and insights through a clean, sporty editorial interface backed by a powerful admin panel.

---

## Tech Stack

| Layer | Technology |
|---|---|
| **Backend** | PHP 8.3+, Laravel 12 |
| **Admin Panel** | Filament 5 |
| **Frontend** | Blade, Tailwind CSS v4, Vite |
| **Database** | MySQL |
| **Media** | Spatie Media Library + Google Drive |
| **Auth & ACL** | Spatie Laravel Permission |
| **SEO** | artesaos/seotools, Spatie Sitemap |
| **Search** | MySQL Full-Text Search |
| **Testing** | Pest 4 |

---

## Features

- **Blog Engine** — Posts with categories (parent/child hierarchy), tags, excerpts, meta descriptions, and FAQ sections
- **Dynamic Sitemap** — Auto-generated `/sitemap.xml` covering pages, categories, tags, and published posts
- **Full-Text Search** — MySQL full-text index with fuzzy fallback support
- **Admin Panel** — Filament-powered dashboard with resources for Posts, Categories, Tags, Users, Roles, Permissions, and Contact Messages
- **Media Management** — Image upload with automatic WebP conversion (thumbnail + optimized sizes) via Spatie Media Library
- **Google Drive Backup** — Automated backups pushed to Google Drive via Spatie Backup
- **Activity Log** — Audit trail on Posts and Categories via Spatie Activity Log
- **General Settings** — Site-wide settings managed from the admin panel
- **Contact Form** — Rate-limited contact form (5 requests/min per IP)
- **Static Pages** — About Us, Contact, Privacy Policy, Disclaimer, Terms & Conditions, Pedoman Media Siber

---

## Prerequisites

- PHP >= 8.3
- Composer
- Node.js >= 20 & npm
- MySQL 8.0+

---

## Installation

### 1. Clone the repository

```bash
git clone <repository-url> goalpedia
cd goalpedia
```

### 2. One-command setup

```bash
composer run setup
```

This will:
- Install PHP dependencies (`composer install`)
- Copy `.env.example` to `.env`
- Generate an application key
- Run database migrations
- Install Node.js dependencies
- Build frontend assets

### 3. Configure environment

Open `.env` and update the following values:

```env
APP_NAME=Goalpedia
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=goalpedia
DB_USERNAME=root
DB_PASSWORD=

# Google Drive (for backups)
GOOGLE_DRIVE_CLIENT_ID=
GOOGLE_DRIVE_CLIENT_SECRET=
GOOGLE_DRIVE_REFRESH_TOKEN=
GOOGLE_DRIVE_FOLDER_ID=
GOOGLE_DRIVE_FOLDER=

# Mail
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=hello@goalpedia.com
MAIL_FROM_NAME=Goalpedia
```

### 4. Run migrations & seed

```bash
php artisan migrate --seed
```

### 5. Create the first admin user

```bash
php artisan make:filament-user
```

---

## Development

Start all services concurrently (server + queue + Vite):

```bash
composer run dev
```

Or run them individually:

```bash
php artisan serve          # Laravel dev server
php artisan queue:listen   # Queue worker
npm run dev                # Vite HMR
```

---

## Project Structure

```
app/
├── Filament/
│   ├── Pages/
│   │   ├── BackupManager.php      # Manage site backups
│   │   └── GeneralSettings.php    # Site-wide settings page
│   └── Resources/
│       ├── Activities/            # Activity log viewer
│       ├── Categories/            # Category CRUD
│       ├── ContactMessages/       # Contact form submissions
│       ├── Permissions/           # Permission management
│       ├── PostFaqs/              # Post FAQ management
│       ├── Posts/                 # Post CRUD with media
│       ├── Roles/                 # Role management
│       ├── TagResource/           # Tag management
│       └── Users/                 # User management
├── Http/
│   └── Controllers/
│       ├── BlogController.php     # Homepage, category, tag, search, author
│       ├── PageController.php     # Static pages
│       └── PostController.php     # Post detail (2-segment & 3-segment URLs)
├── Models/
│   ├── Category.php               # Hierarchical categories (parent/child)
│   ├── Post.php                   # Blog posts with media, tags, FAQs
│   ├── PostFaq.php                # FAQ items per post
│   ├── SiteSetting.php            # Site configuration
│   ├── User.php
│   └── ...
├── Observers/                     # Model event observers
├── Providers/                     # Service providers
└── Settings/
    └── GeneralSettings.php        # Spatie settings class

database/
├── factories/                     # Model factories for testing/seeding
├── migrations/                    # All database migrations
├── seeders/                       # Database seeders
└── settings/                      # Spatie settings migrations

resources/
├── css/                           # App styles (Tailwind v4)
├── js/                            # App JavaScript
└── views/
    ├── blog/                      # Blog views (index, show, category, tag, author, search)
    ├── components/                # Reusable Blade components
    ├── errors/                    # Error pages
    ├── layouts/                   # App layout (app.blade.php)
    └── pages/                     # Static pages (about, contact, privacy, tos, etc.)

routes/
├── console.php                    # Scheduled commands
└── web.php                        # All web routes
```

---

## URL Structure

| Route | Description |
|---|---|
| `/` | Blog homepage |
| `/kategori/{slug}` | Category listing |
| `/tag/{slug}` | Tag listing |
| `/search` | Full-text search |
| `/penulis/{username}` | Author page |
| `/{category}/{post}` | Post (flat category) |
| `/{parent}/{category}/{post}` | Post (nested category) |
| `/about-us` | About page |
| `/contact` | Contact form |
| `/privacy-policy` | Privacy policy |
| `/disclaimer` | Disclaimer |
| `/terms-and-conditions` | Terms & Conditions |
| `/pedoman-media-siber` | Pedoman Media Siber |
| `/sitemap.xml` | Dynamic XML sitemap |
| `/admin` | Filament admin panel |

---

## Testing

```bash
# Run all tests
composer run test

# Run with filter
php artisan test --compact --filter=PostTest
```

---

## Code Style

This project uses Laravel Pint for code formatting. Run after any PHP changes:

```bash
vendor/bin/pint --dirty
```

---

## Deployment

Goalpedia can be deployed to [Laravel Cloud](https://cloud.laravel.com/) or any standard PHP host.

Before deploying:

```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

---

## Brand

| | |
|---|---|
| **Primary Color** | `#093FB4` (Blue — trust + sporty) |
| **Accent Color** | `#ED3500` (Red — energy + urgency) |
| **Background** | `#FFFCFB` (Off-white) |
| **Font** | Poppins |

See [`docs/brand-guidelines.md`](docs/brand-guidelines.md) for full design specifications.

---

## License

MIT
