# AGENTS.md — CreditosHerrera

Laravel 12 app for "Ventanilla Única Digital" (municipal government portal). Early stage — mostly a landing page.

## Commands

- **Setup from scratch:** `composer setup` (creates `.env`, generates key, runs migrations, installs npm, builds)
- **Dev server (all services):** `composer dev` — runs `php artisan serve`, `queue:listen`, `pail` (log watcher), and `npm run dev` (Vite) concurrently
- **Run tests:** `composer test` (runs `artisan config:clear` then `artisan test`)
- **Single test file:** `php artisan test tests/Feature/ExampleTest.php`
- **Format:** `./vendor/bin/pint`
- **Build frontend:** `npm run build`
- **Docker:** `docker compose up` — serves on port **8080**, Apache + PHP 8.2

## Key facts

- Tests use **in-memory SQLite** by default (configured in `phpunit.xml`)
- No custom controllers or models yet — only `User.php`, base `Controller.php`
- Routes: `/` (welcome) and `/gestion` (route exists, no view file yet)
- Frontend: **Tailwind CSS v4** (`@tailwindcss/vite` plugin), Vite, vanilla JS with Axios
- PWA support with service worker registration (`resources/js/app.js`)
- No `opencode.json`, `CLAUDE.md`, `.cursorrules`, or copilot-instructions files exist
- Code style: spaces, 4-space indent (`.editorconfig`); Laravel Pint available
- **Design work:** Load the `frontend-design` skill before building new UI or reshaping existing pages
- `.env` is gitignored; create from `.env.example` on setup (`composer setup` handles this)
