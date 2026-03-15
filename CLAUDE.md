# CLAUDE.md

## Project Overview

Laravel 12 product management application with a public storefront and admin panel. Users can browse products with live USD-to-EUR currency conversion; admins can perform CRUD operations on products. Includes CLI product updates and queued email notifications on price changes.

## Tech Stack

- **Backend:** PHP 8.2, Laravel 12
- **Frontend:** Blade templates, Tailwind CSS 4, Vite 6
- **Database:** SQLite (default)
- **Queue:** Laravel Jobs (sync in dev/test)
- **HTTP Client:** Axios

## Directory Structure

```
app/
  Console/Commands/    # Artisan commands (UpdateProduct)
  Http/Controllers/    # ProductController, AdminController
  Jobs/                # SendPriceChangeNotification
  Mail/                # PriceChangeNotification mailable
  Models/              # Product, User
resources/views/
  admin/               # Edit/add product forms
  emails/              # Price change notification
  products/            # Product list & detail pages
routes/web.php         # All route definitions
database/migrations/   # Schema migrations
database/seeders/      # DatabaseSeeder (10 sample products)
public/uploads/        # User-uploaded product images
tests/
  Feature/             # HTTP/integration tests
  Unit/                # Unit tests
.github/workflows/     # CI (laravel.yml)
```

## Common Commands

```bash
# Install dependencies
composer install
npm install

# Run development server (starts server, queue, logs, and Vite)
composer run dev

# Run individually
php artisan serve          # Backend server
npm run dev                # Vite dev server with HMR
php artisan queue:listen   # Process queued jobs

# Database
php artisan migrate        # Run migrations
php artisan db:seed        # Seed with sample data

# Testing
php artisan test           # Run full PHPUnit suite

# Build frontend for production
npm run build

# Code style
./vendor/bin/pint          # Laravel Pint (PHP code style fixer)
```

## Testing

- **Framework:** PHPUnit 11.5
- **Config:** `phpunit.xml` — two suites: `Unit` and `Feature`
- **Test environment:** SQLite, sync queue, array sessions, bcrypt rounds=4
- **Run:** `php artisan test`

## CI/CD

GitHub Actions (`.github/workflows/laravel.yml`):
- Triggers on push/PR to `main`
- PHP 8.0, Ubuntu latest
- Runs: composer install, key generation, SQLite setup, PHPUnit

## Code Conventions

- **Indentation:** 4 spaces (`.editorconfig`)
- **Line endings:** LF
- **Namespaces:** PSR-4 (`App\`, `Database\`, `Tests\`)
- **Naming:** PascalCase controllers/models, snake_case routes/tables
- **Models:** Singular (`Product`), tables plural (`products`)
- **Architecture:** Standard Laravel MVC with Eloquent ORM, Blade views, queued jobs, mailables

## Database Schema

**products:** id, name, description (nullable text), price (decimal 10,2), image (nullable), timestamps

**users:** Standard Laravel users table

## Key Features

- Public product listing with live EUR conversion (open.er-api.com)
- Admin auth (test credentials: test@example.com / password)
- Product CRUD via admin panel
- CLI product update command (`php artisan product:update`)
- Queued email notifications on price changes
- Image upload to `public/uploads/`

## Environment

Copy `.env.example` to `.env` and generate app key:
```bash
cp .env.example .env
php artisan key:generate
```

Default config uses SQLite at `database/database.sqlite`.
