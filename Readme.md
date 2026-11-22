# Bicho do Mato

Website of the Bicho do Mato NGO: public pages (home, news, partners, testimonials) and an admin area. Laravel 12 + Blade, PHP 8.4.

## Run the app (Sail)

```bash
git clone git@github.com:carloseduardorocha/bicho-do-mato-qaops.git
cd bicho-do-mato-qaops
cp .env.example .env
docker run --rm -v "$PWD":/app -w /app composer:2 install --ignore-platform-req=php
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail npm ci
./vendor/bin/sail npm run build
```

The app runs at <http://localhost>.

## Tests and checks (without Sail)

Only Docker and Node 22 are needed. Run from the project root.

First time:

```bash
cp .env.example .env
docker run --rm -v "$PWD":/app -w /app composer:2 install --ignore-platform-req=php
docker run --rm -v "$PWD":/app -w /app php:8.4-cli php artisan key:generate
npm ci
```

- `composer:2` ships a newer PHP than the lockfile allows, hence `--ignore-platform-req=php`. The code itself runs on PHP 8.4.
- Tests always use SQLite in memory (forced in `phpunit.xml`), whatever database `.env` points to.

| Check | Command |
|---|---|
| Tests | `docker run --rm -v "$PWD":/app -w /app php:8.4-cli php artisan test` |
| PHP code style (Pint) | `docker run --rm -v "$PWD":/app -w /app php:8.4-cli vendor/bin/pint --test` |
| Front-end build | `npm run build` |
| Front-end lint (ESLint) | `npx eslint .` |
| Front-end format (Prettier) | `npm run format:check` |
| PHP dependencies | `docker run --rm -v "$PWD":/app -w /app composer:2 audit` |
| JS dependencies | `npm audit` |

To fix code style instead of only checking it: `vendor/bin/pint` (same container) and `npm run format`.

On Linux, add `-u "$(id -u):$(id -g)"` after `docker run --rm` so the generated files belong to your user.
