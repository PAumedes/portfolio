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
    *   `app`: Ubuntu-based PHP 8.3 image running Laravel Octane (Swoole/FrankenPHP).
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
