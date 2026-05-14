# Portfolio

A high-end, minimalist portfolio application showcasing projects with elegant image galleries, built with Laravel 13, Vue 3, Inertia.js, and fully containerized with Docker.

## Features

✨ **Core Portfolio Features**
- **Multi-Image Project Galleries**: Behance-style galleries with multiple images per project
- **Click-to-View Details**: Elegant project detail pages with full-resolution images
- **Optimized Image Delivery**: Automatic AVIF/WebP conversion with responsive fallbacks via Spatie MediaLibrary
- **About Section**: Dedicated page with biography and professional approach
- **Contact Form**: Seamless contact submission with email notifications and database storage
- **Minimal Social Footer**: Icon-only social links (Instagram, Behance) with clean design

🏗️ **Technical Highlights**
- **Laravel Octane**: High-performance framework with in-memory bootstrapping
- **Vue 3 + Inertia.js**: Server-side routing without API complexity
- **TailwindCSS v4**: Utility-first styling with Satoshi font
- **Spatie MediaLibrary**: Image management with automatic conversions (AVIF, WebP, thumbnails)
- **Admin Dashboard**: Content management for works and notifications

🔒 **Security & Infrastructure**
- **Session Encryption**: Secure session handling with encrypted cookies
- **Redis Authentication**: Password-protected cache layer
- **Security Headers**: HSTS, X-Frame-Options, CSP, and more
- **Multi-Stage Docker Builds**: Optimized images for development and production
- **Health Checks**: All services monitored for availability
- **Non-Root Containers**: All services run as unprivileged users

## Technology Stack

- **Backend**: Laravel 13 with Laravel Octane (PHP 8.3 + FrankenPHP)
- **Frontend**: Vue 3 + Inertia.js + TailwindCSS v4 + Satoshi Font
- **Database**: MySQL 8
- **Cache/Sessions**: Redis 7
- **Media Storage**: Spatie MediaLibrary with S3-compatible storage (Cloudflare R2)
- **Infrastructure**: Docker Compose with dev/prod/test environments
- **CI/CD**: GitHub Actions with automated linting, testing, and Docker builds

## Requirements

- **Docker Desktop** (Mac/Windows) OR **Docker Engine + Docker Compose** (Linux)
- No local PHP, Node, or MySQL installation needed — everything runs in containers

## Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd portfolio
```

### 2. Set Up Environment Variables

Copy the provided `.env` file or create one with sensible defaults:

```bash
# The .env file is already configured with Docker-friendly defaults
cat .env
```

Key environment variables for development:
```
APP_ENV=local
APP_DEBUG=true
DB_HOST=db
REDIS_HOST=redis
REDIS_PASSWORD=portfolio_redis_dev_password
SESSION_ENCRYPT=true
```

### 3. Start the Development Environment

For **first-time setup** (builds images and initializes the database):

```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build
```

For **subsequent runs** (no rebuild needed):

```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d
```

### 4. Install Dependencies and Initialize

Run these commands while the containers are running:

```bash
# Install PHP dependencies
docker compose -f docker-compose.yml -f docker-compose.dev.yml exec app composer install

# Generate application key
docker compose -f docker-compose.yml -f docker-compose.dev.yml exec app php artisan key:generate

# Run database migrations
docker compose -f docker-compose.yml -f docker-compose.dev.yml exec app php artisan migrate

# Seed sample data
docker compose -f docker-compose.yml -f docker-compose.dev.yml exec app php artisan db:seed
```

### 5. Install Frontend Assets

```bash
# Install npm dependencies
docker compose -f docker-compose.yml -f docker-compose.dev.yml exec node npm install

# Start dev server (Vite with hot reload)
# The node service runs automatically with npm run dev
```

### 6. Access the Application

- **Portfolio**: http://localhost:8080
- **Admin Panel**: http://localhost:8080/admin (requires login)
- **Vite Dev Server**: http://localhost:5173 (hot reload assets)

## Development Workflow

### Code Changes (Hot Reload)

No container recreation needed for code changes:

- **PHP files**: Automatically reloaded by Octane
- **Vue components**: Hot Module Replacement via Vite
- **CSS**: Recompiled on save

Simply edit files and refresh your browser.

### Configuration Changes

After modifying `.env` or `config/` files, restart the app container:

```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml restart app
```

### Dependency Changes

When updating `composer.json` or `package.json`:

```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build
```

### Running Tests

```bash
# Run all tests
docker compose -f docker-compose.yml -f docker-compose.dev.yml exec app php artisan test --parallel

# Run specific test file
docker compose -f docker-compose.yml -f docker-compose.dev.yml exec app php artisan test tests/Feature/PortfolioTest.php

# Run tests matching a name
docker compose -f docker-compose.yml -f docker-compose.dev.yml exec app php artisan test --filter=test_name
```

### Code Quality

Before committing:

```bash
# Format PHP code (Laravel Pint)
docker compose -f docker-compose.yml -f docker-compose.dev.yml exec app ./vendor/bin/pint

# Lint and format Vue/JS
docker compose -f docker-compose.yml -f docker-compose.dev.yml exec node npm run lint
docker compose -f docker-compose.yml -f docker-compose.dev.yml exec node npm run format
```

## Stopping the Environment

```bash
# Stop all containers (preserves data)
docker compose -f docker-compose.yml -f docker-compose.dev.yml down

# Stop and remove volumes (clears database)
docker compose -f docker-compose.yml -f docker-compose.dev.yml down -v
```

## Production Deployment

For production, use the production override:

```bash
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d --build
```

The production configuration includes:
- Optimized resource limits (CPU/memory)
- Disabled debug mode
- Health checks for orchestration
- Production-ready nginx configuration

## Architecture

### Request Flow

```
Browser → Nginx (reverse proxy) → Laravel Octane/FrankenPHP → Inertia → Vue (SPA)
```

**No separate API**: Inertia.js eliminates the need for a traditional REST API. Controllers return `Inertia::render()` with props, and Vue components receive them directly.

### Project Structure

```
portfolio/
├── app/                          # Laravel application logic
│   ├── Http/Controllers/         # Route handlers
│   ├── Models/                   # Eloquent models
│   ├── Services/                 # Business logic
│   ├── Repositories/             # Data access with caching
│   └── Notifications/            # Email/database notifications
├── database/
│   ├── migrations/               # Schema changes
│   └── seeders/                  # Sample data
├── resources/
│   ├── js/Pages/                 # Vue page components
│   ├── js/Components/            # Reusable Vue components
│   ├── js/Composables/           # Vue composition functions
│   ├── css/                      # TailwindCSS
│   └── views/app.blade.php       # HTML entrypoint
├── routes/web.php                # Application routes
├── docker/                       # Dockerfiles & configs
│   ├── app/Dockerfile            # PHP/Laravel
│   ├── web/Dockerfile            # Nginx
│   ├── redis/Dockerfile          # Redis
│   └── node/Dockerfile           # Node.js build environment
├── docker-compose.yml            # Main service definitions
├── docker-compose.dev.yml        # Development overrides
├── docker-compose.prod.yml       # Production overrides
└── docker-compose.test.yml       # Testing environment
```

## Important Notes

⚠️ **Octane Memory Management**: Because Octane bootstraps the Laravel application once and keeps it in memory, you **must restart the app container** after modifying `.env` or configuration files:

```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml restart app
```

ℹ️ **Default User ID**: On Linux, containers run with your user ID (PUID/PGID) to prevent permission issues. The `.env` file detects this automatically.

📚 **Further Documentation**: See `CLAUDE.md` for detailed development guidelines, architecture decisions, and advanced usage.
