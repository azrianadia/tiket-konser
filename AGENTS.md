# AGENTS.md (repo‑specific guidance)

- **Setup**: run `composer install && cp .env.example .env && php artisan key:generate && php artisan migrate --force && npm install --ignore-scripts && npm run build` (available as `composer setup`).
- **Development**: `composer dev` starts PHP server, queue listener, Laravel Pail logs, and Vite dev server concurrently.
- **Frontend**: `npm run dev` launches Vite; `npm run build` produces production assets via `vite build`.
- **Testing**: `composer test` clears config then runs `php artisan test` using in‑memory SQLite (see `phpunit.xml` env vars).
- **Important env for tests**: `APP_ENV=testing`, `CACHE_STORE=array`, `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`, `QUEUE_CONNECTION=sync`, `SESSION_DRIVER=array`.
- **Command order**: when reproducing a fresh environment, run the setup script before any other commands; it configures the .env and runs migrations.
- **Concurrency colors**: `composer dev` uses `concurrently -c "#93c5fd,#c4b5fd,#fb7185,#fdba74"` to color‑code server, queue, logs, and Vite processes.
- **Laravel version**: framework ^13.8, PHP ^8.3.
- **Node version**: Vite ^8, TailwindCSS ^4.
- **No separate lint/typecheck**: repo relies on PHPStan/Pint via Composer scripts (not defined), so agents should not assume JS linting steps.
