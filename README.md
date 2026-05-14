# Portfolio

A minimalist portfolio application with elegant image galleries, built with Laravel 13, Vue 3, and Docker.

## What This Is

A clean, professional portfolio that displays your work with:
- Multi-image galleries for each project (like Behance)
- Click to view full project details
- About page with your story
- Contact form with notifications
- Social media links (minimal footer)
- Fast performance with optimized images (AVIF/WebP)

## Tech Stack

- **Backend**: Laravel 13 + Laravel Octane (PHP 8.3)
- **Frontend**: Vue 3 + TailwindCSS v4
- **Database**: MySQL 8
- **Cache**: Redis
- **Everything**: Runs in Docker containers

## Requirements

Just install Docker:
- **Docker Desktop** (Mac/Windows)
- **Docker + Docker Compose** (Linux)

That's it. You don't need PHP, Node, or MySQL installed locally.

## Quick Start

### 1. Get the Code

```bash
git clone <repository-url>
cd portfolio
```

### 2. Start the Development Server

First time only:
```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build
```

After that:
```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d
```

### 3. Set Up the Database

```bash
docker exec portfolio_app composer install
docker exec portfolio_app php artisan key:generate
docker exec portfolio_app php artisan migrate
docker exec portfolio_app php artisan db:seed
```

### 4. Install Frontend Assets

```bash
docker exec portfolio_node npm install
```

The dev server starts automatically. You'll see hot reload working.

### 5. Open Your Browser

- **Portfolio**: http://localhost:8080
- **Admin**: http://localhost:8080/admin

Done! Start editing files and refresh your browser to see changes.

## Common Commands

Run these from the project directory:

### Backend (PHP/Laravel)

```bash
# Run tests
docker exec portfolio_app php artisan test --parallel

# Run one test
docker exec portfolio_app php artisan test --filter=testName

# Fix code formatting
docker exec portfolio_app ./vendor/bin/pint

# Run migrations
docker exec portfolio_app php artisan migrate

# Seed database
docker exec portfolio_app php artisan db:seed
```

### Frontend (Vue/Node)

```bash
# Format code
docker exec portfolio_node npm run format

# Check for errors
docker exec portfolio_node npm run lint

# Build for production
docker exec portfolio_node npm run build
```

### Database & Cache

```bash
# See what's in the database
docker exec portfolio_db mysql -u portfolio_user -p${DB_PASSWORD} portfolio -e "SELECT * FROM works;"

# Flush Redis cache
docker exec portfolio_redis redis-cli flushall
```

## Development

### Making Code Changes

Just edit files. Your changes reload automatically:
- **PHP files** → Reload automatically in Octane
- **Vue files** → Hot reload in your browser
- **CSS** → Recompile on save

No container restart needed. Just refresh your browser.

### After Changing Configuration

If you modify `.env` or `config/` files, restart the app:

```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml restart app
```

### After Adding Packages

If you update `composer.json` or `package.json`, rebuild:

```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build
```

## Stop Everything

```bash
# Keep your database (just stop containers)
docker compose -f docker-compose.yml -f docker-compose.dev.yml down

# Remove everything including database (fresh start)
docker compose -f docker-compose.yml -f docker-compose.dev.yml down -v
```

## Project Structure

```
portfolio/
├── app/                  # Backend logic (Models, Controllers, etc.)
├── resources/
│   ├── js/Pages/         # Vue pages
│   ├── js/Components/    # Vue components
│   └── css/              # Tailwind styles
├── database/
│   ├── migrations/       # Database schema
│   └── seeders/          # Sample data
├── docker/               # Dockerfile configs
├── routes/web.php        # URL routes
├── tests/                # Tests
└── CLAUDE.md             # Developer notes
```

## How It Works

1. User visits your portfolio at `http://localhost:8080`
2. Nginx (web server) receives the request
3. Laravel runs the request in Octane (very fast)
4. Vue renders the page in the browser
5. When you click a project, it shows the gallery with multiple images
6. Images are automatically optimized (AVIF/WebP with fallbacks)

No API. No JSON. Just direct server-to-browser rendering with Inertia.js.

## Admin Panel

Go to `/admin` to manage:
- Projects (works) and their images
- Contact form submissions
- Notifications

Login with your admin credentials.

## Important

⚠️ **After changing `.env` or config files**, restart the app:
```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml restart app
```

Octane keeps your app in memory for speed, so changes need a restart.

## Need Help?

Check `CLAUDE.md` for detailed developer docs, testing, deployment, and architecture decisions.
