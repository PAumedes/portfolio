# Portfolio Application Blueprint (`GEMINI.md`)

This document serves as the persistent blueprint and rulebook for autonomous subagents building the high-end, full-stack portfolio application.

## 1. System Architecture

### Technology Stack
*   **Backend:** Laravel 13 using Laravel Octane (for parallel PHP execution)
*   **Media Engine:** `spatie/laravel-medialibrary`
*   **Storage:** Cloudflare R2 (S3-compatible) with custom AWS_URL subdomain
*   **Frontend:** Vue 3 integrated via Inertia.js with Shadcn Vue components
*   **Database:** MySQL
*   **Cache & Queue:** Redis
*   **Infrastructure:** Fully dockerized (Ubuntu base image)
*   **Design/Typography:** Satoshi (sans-serif) as the primary font family. The frontend must convey a clean, minimal, and expensive-looking aesthetic.

### Folder Structure (High-Level)
```text
/
├── app/               # Laravel core (Models, Controllers, Services)
├── bootstrap/         # Laravel bootstrapping
├── config/            # Application configuration
├── database/          # Migrations, Factories, Seeders
├── docker/            # Dockerfiles, configs (nginx, php, octane, etc.)
├── public/            # Public assets (compiled JS/CSS, images, fonts)
├── resources/
│   ├── css/           # Tailwind / Global CSS
│   ├── js/            # Vue components, Inertia setup, Composables
│   └── views/         # Blade entrypoint (app.blade.php)
├── routes/            # Web and API routes
├── tests/             # Pest (Unit/Feature) and Cypress (E2E) tests
├── docker-compose.yml # Main Docker orchestration
└── GEMINI.md          # This blueprint
```

### Docker Networking Topology
*   **Network:** An isolated bridge network (e.g., `portfolio_network`).
*   **Services:**
    *   `app`: FrankenPHP-based PHP 8.3 image running Laravel Octane.
    *   `web`: Nginx reverse proxy routing requests to the `app` service.
    *   `db`: MySQL service with persistent volume mounting.
    *   `redis`: Redis service for fast caching and session/queue management.
    *   `node`: Ephemeral service for frontend asset compilation (Vite).

## 2. Development Guardrails

Subagents **MUST** strictly adhere to the following rules at all times. Failure to do so will result in CI/CD pipeline failures.

### Rule 1: Code Styling and Formatting
*   **Backend (PHP):** Strict enforcement of **Laravel Pint**. Code must be clean, readable, and perfectly formatted.
*   **Frontend (JS/Vue):** Strict enforcement of **ESLint** and **Prettier**.
*   **Constraint:** Code MUST NOT pass CI/CD without meeting these standards. Agents must run styling fixes before committing.

### Rule 2: Testing Strategy
*   **Coverage Target:** Maintain approximately **85% code coverage**.
*   **Focus:** Test critical business logic, complex data transformations, and essential user flows.
*   **Exclusions:** Do NOT write tests for trivial getters/setters or boilerplate methods.
*   **Frameworks:**
    *   Backend: **Pest** (Unit and Feature tests).
    *   Frontend/E2E: **Cypress**.

### Rule 3: Documentation and Comments
*   **API Documentation:** All APIs must be explicitly documented (e.g., using Scribe or OpenAPI/Swagger annotations).
*   **Code Comments:** Write comments to explain **"why"** complex logic exists, not **"what"** it is doing. The code itself should clearly describe the "what" via expressive naming conventions.

### Rule 4: Laravel Octane Development
*   **Environment Changes:** Because Laravel Octane keeps the application bootstrapped in RAM, any changes made to the `.env` file or configuration files require a container restart (`docker compose restart app`) to take effect. Failure to restart will lead to outdated or broken configuration states.

## 3. The Execution Graph

This section outlines the phased, step-by-step roadmap for building the application. Subagents must follow this order. 

**Legend:**
*   🛑 **Sequential Blocker:** Must be completed before moving to the next item or phase.
*   ⚡ **Parallel Task:** Can be executed simultaneously by separate subagents once the phase's blockers are cleared.

---

### Phase 1: Foundation & Infrastructure
*   🛑 **[Sequential Blocker] 1.1 Docker Environment Setup:** Create `docker-compose.yml` and the Ubuntu-based Dockerfiles for `app` (Octane), `web` (Nginx), `db` (MySQL), and `redis`. Ensure the networking topology is correct.
*   🛑 **[Sequential Blocker] 1.2 Laravel Initialization:** Install Laravel 13 within the `app` container. Configure `.env` to connect to MySQL and Redis. Install and configure Laravel Octane.
*   🛑 **[Sequential Blocker] 1.3 CI/CD & Linting Setup:** Install and configure Laravel Pint, ESLint, and Prettier. Set up a basic CI pipeline (e.g., GitHub Actions) to enforce styling and block on failure.

### Phase 2: Frontend & Testing Scaffolding
*   🛑 **[Sequential Blocker] 2.1 Inertia & Vue 3 Setup:** Install Inertia.js and Vue 3. Configure Vite for asset compilation. Create the main `app.blade.php` layout.
*   ⚡ **[Parallel] 2.2 Styling System Integration:** Configure TailwindCSS (if used) or base CSS. Install and configure the "Satoshi" font globally to ensure a clean, minimal aesthetic.
*   ⚡ **[Parallel] 2.3 Testing Frameworks Setup:** Install and configure Pest for the backend and Cypress for E2E testing. Set up testing databases and environment variables.

### Phase 3: Core Application Architecture
*   🛑 **[Sequential Blocker] 3.1 Database Design & Migrations:** Design the core schema (e.g., Projects, Experiences, Skills, Contact). Write and run migrations. Implement the `Work` model with `HasMedia` and `InteractsWithMedia` for Cloudflare R2 uploads.
*   ⚡ **[Parallel] 3.2 Backend Models & Repositories:** Create Eloquent models, factories, and seeders. Register Spatie media conversions (`thumb`: 400px WebP, `preview`: 1600px AVIF with WebP fallback). Ensure proper relationships and scopes.
*   ⚡ **[Parallel] 3.3 Frontend Base Components:** Build the foundational, expensive-looking UI components using Shadcn Vue. Ensure a Gap-Px CSS column-based masonry grid logic is implemented with intersection observer reveal-on-scroll effects.

> [!NOTE]
> **Cloudflare R2 CORS Requirement:** The R2 Bucket must have a CORS policy allowing GET requests from the production domain so Vue can render images properly.

### Phase 4: Feature Implementation (Iterative)
*   🛑 **[Sequential Blocker] 4.1 Routing & API Design:** Define Laravel routes and Inertia endpoints. Create necessary Controllers.
*   ⚡ **[Parallel] 4.2 Backend Business Logic:** Implement complex logic, form requests (validation), and API resources. Write Pest tests focusing on the "happy path" and critical edge cases (aiming for 85% coverage). Document APIs.
*   ⚡ **[Parallel] 4.3 Frontend Page Assembly:** Assemble Vue components into full pages (Home, Portfolio, About, Contact). Connect to Inertia props. Ensure animations and typography feel high-end.

### Phase 5: Polish & E2E Verification
*   🛑 **[Sequential Blocker] 5.1 Cypress E2E Testing:** Write and execute Cypress tests for full user journeys (e.g., navigating the portfolio, submitting a contact form).
*   ⚡ **[Parallel] 5.2 Performance Tuning:** Optimize Eloquent queries (N+1 fixes), configure Redis caching for heavy reads, and verify Octane worker performance.
*   ⚡ **[Parallel] 5.3 Aesthetic Review:** Final pass on UI/UX to guarantee the minimal, expensive aesthetic. Check font rendering, spacing, and micro-interactions.

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
- \@inertiajs/vue3 (INERTIA_VUE) - v1
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
