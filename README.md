# Portfolio

A high-end, full-stack portfolio application built with Laravel 13, Vue 3, Inertia.js, and Docker.

## Technology Stack
- **Backend**: Laravel 13 running on Laravel Octane (PHP 8.3 + FrankenPHP)
- **Frontend**: Vue 3 + Inertia.js + TailwindCSS + Satoshi Font
- **Database**: MySQL
- **Cache / Session**: Redis
- **Infrastructure**: Fully Dockerized (Ubuntu base)

## Requirements
- Docker Desktop or Docker Engine + Docker Compose

## How to Run

1. **Clone the repository** (if you haven't already).
2. **Review your `.env`**: An initial `.env` file has been provided with sensible defaults for the Docker environment.
3. **Start the Development Environment**:
   ```bash
   docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build
   ```
   *For production, use:*
   ```bash
   docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d --build
   ```
4. **Install Dependencies & Initialize** (Run these commands while the development environment is up):
   ```bash
   docker compose -f docker-compose.yml -f docker-compose.dev.yml exec app composer install
   docker compose -f docker-compose.yml -f docker-compose.dev.yml exec app php artisan key:generate
   docker compose -f docker-compose.yml -f docker-compose.dev.yml exec app php artisan migrate
   ```
5. **Install Frontend Assets**:
   ```bash
   docker compose -f docker-compose.yml -f docker-compose.dev.yml exec node npm install
   # For production build, use:
   docker compose -f docker-compose.yml -f docker-compose.dev.yml exec node npm run build
   ```

## Architecture Notes
- The application uses **Laravel Octane** for significant performance boosts by keeping the framework bootstrapped in memory. 
  - ⚠️ **Important:** Because Octane keeps the application in memory, you MUST restart the `app` container (`docker compose restart app`) whenever you modify the `.env` file or configuration.
- The `app` Dockerfile is configured with a multi-stage build for optimal image sizes and runs as a non-root user for enhanced security.
- See `GEMINI.md` for a comprehensive blueprint and execution roadmap of the project.
