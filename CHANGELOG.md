# Changelog

All notable changes to this project are documented in this file.

## [Unreleased]

### Fixed
- Media seeding: now creates 7 media records per work item instead of 1
- WorkRepository: removed invalid `with('media')` calls that prevented media loading
- All images per project now properly returned and displayed in gallery grid

## [1.1.0] - 2026-05-14

### Added
- Redis configuration for development with disabled authentication
- Blade view compiler cache path configuration (critical fix for 500 errors)
- Proper storage directory permissions and .gitignore structure
- Media processing with automatic AVIF/WebP conversion support

### Fixed
- **CRITICAL:** Fixed "Please provide a valid cache path" error blocking all requests
  - Created `config/view.php` with proper Blade cache path
  - Set `VIEW_COMPILED_PATH=/tmp/laravel-views` in .env
- **CRITICAL:** Fixed Redis authentication errors in contact form and queue processing
  - Disabled Redis password requirement for development
  - Updated `docker/redis/entrypoint.sh` to run without `--requirepass`
- Fixed file permission errors in storage directory
- Removed 46+ compiled Blade view files from git history
- Fixed routing from `/work/{slug}` to `/project/{slug}`

### Changed
- Updated database seeding to create Media records directly via `Media::create()`
- Modified error handler suppression in AppServiceProvider for FrankenPHP compatibility
- Simplified WorkRepository methods by removing unnecessary eager loading

### Infrastructure
- Redis runs in protected mode OFF for development convenience
- Docker Compose uses `docker-compose.yml` + `docker-compose.dev.yml` for environment-specific setup
- Octane/FrankenPHP with automatic file watching for hot reload on PHP changes
- Vite hot module replacement for Vue component changes

## [1.0.0] - 2026-05-13

Initial working version with core portfolio features.

### Added
- **Frontend:** Vue 3 + Inertia.js + TailwindCSS v4 SPA
- **Backend:** Laravel 13 + Laravel Octane (FrankenPHP)
- **Database:** MySQL 8 with Redis caching and queuing
- **Media:** Spatie MediaLibrary with Cloudflare R2 storage integration
- **Authentication:** Custom session-based login (no Jetstream/Breeze)
- **Features:**
  - Portfolio grid displaying work projects
  - Individual project detail pages with lightbox gallery
  - Admin dashboard for managing portfolio works
  - Contact form with database notification system
  - Responsive design with Satoshi font typography

### Infrastructure
- Full Docker containerization (Ubuntu base, multi-stage builds)
- Automated CI/CD via GitHub Actions (Pint, ESLint, Prettier, Pest)
- Development environment with hot reload support
- Production-ready configuration with Cloudflare R2 image storage

## [0.1.0] - 2026-05-13

Initial project setup and scaffolding.

### Added
- Laravel 13 project structure
- Docker environment configuration
- Git repository initialization
- README and documentation
- Package dependencies for PHP and Node

---

## Migration Notes

### From 1.0.0 to 1.1.0

**Database:** No migrations required. Existing work records will function with new media seeding approach.

**Configuration:** 
- Ensure `.env` has `VIEW_COMPILED_PATH=/tmp/laravel-views`
- Ensure `REDIS_PASSWORD=` (empty string, no password)
- Run `php artisan db:seed` to populate media records

**Cache:** Redis cache store now works without authentication. Clear cache if upgrading from previous build:
```bash
docker compose exec app php artisan cache:clear
```

---

## Development

See [CLAUDE.md](./CLAUDE.md) for development setup, testing, and deployment instructions.
