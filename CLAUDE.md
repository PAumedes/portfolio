# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Technology Stack

- **Backend:** Laravel 13 + Laravel Octane (FrankenPHP), PHP 8.3
- **Frontend:** Vue 3 + Inertia.js + TailwindCSS v4 + Satoshi font
- **Database:** MySQL 8 | **Cache/Queue:** Redis | **Media:** Spatie MediaLibrary → Cloudflare R2 (S3-compatible)
- **Infrastructure:** Fully Dockerized (Ubuntu base, multi-stage build)

## Requirements

- **Docker Desktop** (Mac/Windows) OR **Docker Engine + Docker Compose** (Linux)
- Project runs entirely in containers — no local PHP/Node install needed

## Development Environment

All commands run inside Docker containers. The dev stack is composed of two files:

```bash
# First-time setup (builds images, creates containers, runs migrations/seeds)
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build
docker compose -f docker-compose.yml -f docker-compose.dev.yml exec app php artisan migrate
docker compose -f docker-compose.yml -f docker-compose.dev.yml exec app php artisan db:seed

# Regular development (NO --build flag needed for code changes)
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d

# Restart app after .env or config/ changes (Octane keeps app in memory)
docker compose -f docker-compose.yml -f docker-compose.dev.yml restart app
```

**Hot Reload (Automatic):**
- **PHP code changes:** Reloaded automatically by Octane (file watching)
- **Vue components:** Hot Module Replacement via Vite on :5173
- **No container recreation needed** for code changes — only for dependency upgrades

**When to rebuild (`--build`):**
- Added/changed PHP packages in `composer.json`
- Added/changed npm packages in `package.json`
- Modified Dockerfile or Docker configuration

**Important:** Laravel Octane keeps the app bootstrapped in memory. After `.env` or `config/` changes you **must** restart the app container:

```bash
docker compose restart app
```

### First-Time Setup (Permissions)

On first setup, create the cache/log directories with proper permissions:

```bash
mkdir -p storage/logs storage/framework/{cache,views} bootstrap/cache
chmod 755 storage bootstrap
chmod 775 storage/logs storage/framework/{cache,views} bootstrap/cache
```

**Why:** Docker runs the app as `uid 1000` (your user) via `docker-compose.dev.yml`. These directories must be writable by your user for Octane's file state tracking and Laravel's cache/logs. The directories are gitignored so they won't be committed.

### Using Make Commands (Recommended)

Instead of typing long docker-compose commands, use the `Makefile`:

```bash
make up              # Start containers
make down            # Stop containers
make build           # Rebuild images
make restart         # Restart app (after .env changes)
make logs            # Tail app logs
make shell           # Open bash in app container
make test            # Run tests
make pint            # Fix PHP style
make migrate         # Run migrations
make seed            # Seed database
```

## Project Structure

```
portfolio/
├── app/                    # Laravel core (Models, Controllers, Services, Repositories)
├── database/               # Migrations, Factories, Seeders
├── docker/                 # Dockerfiles & configs (nginx, php, octane)
├── public/                 # Compiled assets, images, fonts
├── resources/
│   ├── css/                # Tailwind / Global CSS
│   ├── js/                 # Vue components, Inertia setup, Composables
│   └── views/              # Blade entrypoint (app.blade.php)
├── routes/                 # Web routes
├── tests/                  # Pest (backend) & Cypress (E2E)
├── .agents/skills/         # Domain-specific skills (17 total)
├── docker-compose.yml      # Main orchestration
├── docker-compose.dev.yml  # Dev overrides
└── CLAUDE.md               # This file
```

## Development Guardrails

Adhere to these standards to pass CI/CD:

**Code Styling:**
- **PHP:** Run `vendor/bin/pint --dirty` before committing
- **Vue/JS:** Run `npm run format && npm run lint` before committing
- CI blocks on style violations

**Testing:**
- Target **~85% code coverage** on business logic
- Focus on critical flows, complex transformations, edge cases
- Skip trivial getters/setters and boilerplate
- Backend: Pest | Frontend/E2E: Cypress
- Always write tests; verify with `php artisan test --parallel`

**Documentation:**
- **API documentation** is mandatory (use Scribe or OpenAPI annotations)
- **Code comments:** Explain *why*, not *what*. Use expressive names; let code speak for itself
- Generate references from code, don't hardcode docs

## Common Commands

All executed via `docker compose -f docker-compose.yml -f docker-compose.dev.yml exec <service> <cmd>`.

### Backend (PHP)

```bash
# Run all tests
exec app php artisan test --parallel

# Run a single test file
exec app php artisan test tests/Feature/PortfolioTest.php

# Run tests matching a name
exec app php artisan test --filter=test_name

# Fix code style (Laravel Pint)
exec app ./vendor/bin/pint

# Check style without fixing (CI mode)
exec app ./vendor/bin/pint --test

# Migrate database
exec app php artisan migrate

# Seed database
exec app php artisan db:seed
```

### Frontend (Node)

```bash
# Production build
exec node npm run build

# Lint (ESLint)
exec node npm run lint

# Format (Prettier)
exec node npm run format

# Check formatting without writing (CI mode)
exec node npx prettier --check "resources/js/**/*.{js,vue}"
```

## Code Architecture

### Request Flow

```
Browser → Nginx (:8080) → Octane/FrankenPHP (:8000) → Laravel → Inertia → Vue (SPA)
```

Inertia.js eliminates a separate API layer: controllers return `Inertia::render('PageName', $props)` and the Vue page receives those props directly. The single Blade entrypoint is `resources/views/app.blade.php`.

### Backend Structure

- **Controllers** (`app/Http/Controllers/`) — thin; delegate to services/repositories.
  - `Admin/` — auth-protected routes for managing works and notifications.
  - `Auth/LoginController.php` — session-based login (no Jetstream/Breeze).
- **Services** (`app/Services/`) — business logic (e.g., `ContactService` handles email + DB notification dispatch).
- **Repositories** (`app/Repositories/`) — data access with Redis cache layer (`WorkRepository`).
- **Resources** (`app/Http/Resources/`) — API/Inertia response shaping (`WorkResource` maps Spatie media URLs).
- **Notifications** (`app/Notifications/`) — `ContactFormNotification` is queued, delivers via `mail` + `database` channels.

### Work / Media Model

`Work` implements Spatie's `HasMedia`. Three media conversions are registered in `Work::registerMediaConversions()`:

| Conversion | Width | Format | Use |
|---|---|---|---|
| `thumb` | 400px | WebP | Portfolio grid thumbnails |
| `preview` | 1600px | AVIF | Lightbox / full view |
| `preview_fallback` | 1600px | WebP | Fallback for AVIF |

Media is stored in the `default` collection and served from Cloudflare R2.

### Frontend Structure

Vue pages live in `resources/js/Pages/` and are resolved by name via Inertia (`resolvePageComponent`). The `@` alias maps to `resources/js/`.

- **Layouts** (`resources/js/Layouts/`) — `AdminLayout.vue` wraps all admin pages with a fixed sidebar.
- **Composables** (`resources/js/Composables/`) — `useReveal.js` drives IntersectionObserver reveal-on-scroll animations. Attach `galleryRefs` array to elements to opt in.
- **Shadcn Vue components** live in `resources/js/Components/ui/` (auto-discoverable, not listed here).
- **No global layout** for public pages — each public page is self-contained.

### Authentication

Custom session-based auth (no Breeze/Jetstream). Login throttled at 5 attempts/minute. Admin routes protected by `auth` middleware under `/admin` prefix.

### Routing Convention

| Prefix | Middleware | Purpose |
|---|---|---|
| `/` | none | Public portfolio pages |
| `/admin/*` | `auth` | Admin CMS (works, notifications) |
| `/login` | `guest` | Auth |

## CI/CD

GitHub Actions (`.github/workflows/ci.yml`) runs on every push/PR to `main`:

1. Laravel Pint (`--test`) — blocks on style violations
2. ESLint
3. Prettier check
4. Pest tests (`--parallel`)

**CI runs against SQLite** (no Docker in CI). Pint and Prettier checks are read-only; run the fix commands locally before pushing.

## Design Constraints

- **Typography:** Satoshi font only (`font-satoshi` class, loaded from `/fonts/Satoshi-Variable.woff2`).
- **Aesthetic:** Minimal, high-end. Dark base (`zinc-950`). Avoid decorative clutter.
- **Coverage target:** ~85% for business logic. Skip trivial getters/boilerplate.
- **AppServiceProvider** suppresses a `tempnam()` E_WARNING from FrankenPHP that would otherwise 500 under Octane's strict error handling — do not remove it.

## Skills Directory

The project includes **17 domain-specific skills** in `.agents/skills/`. Activate the relevant skill when spawning an agent for specialized work:

| Task | Skill | Use when |
|---|---|---|
| Laravel backend | `laravel-specialist` | Models, migrations, APIs, Sanctum, queues |
| PHP optimization | `php-pro` | Performance tuning, refactoring, design patterns |
| Vue frontend | `vue-expert` | Components, Composition API, state management |
| Inertia pages | `inertia-vue-development` | Vue pages, forms, navigation (auto-added by Boost) |
| Styling | `tailwindcss-development` | TailwindCSS utilities, responsive design (auto-added by Boost) |
| Code quality | `code-reviewer` | PR review, code patterns, best practices |
| Security | `security-reviewer` | Security audit, OWASP, vulnerability assessment |
| Documentation | `code-documenter` | API docs, docstrings, generated reference |
| Architecture | `design-patterns` or `architecture-designer` | System design, refactoring, scalability |
| Database | `database-optimizer` | Query optimization, indexing, schema design |
| Infrastructure | `devops-engineer` | Docker, CI/CD, deployment |

**To activate:** When spawning an agent (e.g., `Agent({ subagent_type: 'general-purpose', prompt: '...' })`), include the skill name in the prompt context or use a specialized agent type that supports it.

===

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.3
- inertiajs/inertia-laravel (INERTIA_LARAVEL) - v2
- laravel/framework (LARAVEL) - v13
- laravel/octane (OCTANE) - v2
- laravel/prompts (PROMPTS) - v0
- tightenco/ziggy (ZIGGY) - v2
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pint (PINT) - v1
- phpunit/phpunit (PHPUNIT) - v11
- @inertiajs/vue3 (INERTIA_VUE) - v1
- eslint (ESLINT) - v8
- prettier (PRETTIER) - v3
- tailwindcss (TAILWINDCSS) - v4
- vue (VUE) - v3

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.
- To check environment variables, read the `.env` file directly.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== inertia-laravel/core rules ===

# Inertia

- Inertia creates fully client-side rendered SPAs without modern SPA complexity, leveraging existing server-side patterns.
- Components live in `resources/js/Pages` (unless specified in `vite.config.js`). Use `Inertia::render()` for server-side routing instead of Blade views.
- ALWAYS use `search-docs` tool for version-specific Inertia documentation and updated code examples.
- IMPORTANT: Activate `inertia-vue-development` when working with Inertia Vue client-side patterns.

# Inertia v2

- Use all Inertia features from v1 and v2. Check the documentation before making changes to ensure the correct approach.
- New features: deferred props, infinite scroll, merging props, polling, prefetching, once props, flash data.
- When using deferred props, add an empty state with a pulsing or animated skeleton.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== octane/core rules ===

# Octane

- Octane boots the application once and reuses it across requests, so singletons persist between requests.
- The Laravel container's `scoped` method may be used as a safe alternative to `singleton`.
- Never inject the container, request, or config repository into a singleton's constructor; use a resolver closure or `bind()` instead:

```php
// Bad
$this->app->singleton(Service::class, fn (Application $app) => new Service($app['request']));

// Good
$this->app->singleton(Service::class, fn () => new Service(fn () => request()));
```

- Never append to static properties, as they accumulate in memory across requests.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== phpunit/core rules ===

# PHPUnit

- This application uses PHPUnit for testing. All tests must be written as PHPUnit classes. Use `php artisan make:test --phpunit {name}` to create a new test.
- If you see a test using "Pest", convert it to PHPUnit.
- Every time a test has been updated, run that singular test.
- When the tests relating to your feature are passing, ask the user if they would like to also run the entire test suite to make sure everything is still passing.
- Tests should cover all happy paths, failure paths, and edge cases.
- You must not remove any tests or test files from the tests directory without approval. These are not temporary or helper files; these are core to the application.

## Running Tests

- Run the minimal number of tests, using an appropriate filter, before finalizing.
- To run all tests: `php artisan test --compact`.
- To run all tests in a file: `php artisan test --compact tests/Feature/ExampleTest.php`.
- To filter on a particular test name: `php artisan test --compact --filter=testName` (recommended after making a change to a related file).

=== inertia-vue/core rules ===

# Inertia + Vue

Vue components must have a single root element.
- IMPORTANT: Activate `inertia-vue-development` when working with Inertia Vue client-side patterns.

</laravel-boost-guidelines>
