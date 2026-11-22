# Bicho do Mato

Website of the Bicho do Mato NGO: public pages (home, news, partners, testimonials) and an admin area. Laravel 12 + Blade (Bootstrap from a CDN, no front-end build), PHP 8.4.

## Run the app (Sail)

```bash
git clone git@github.com:carloseduardorocha/bicho-do-mato-qaops.git
cd bicho-do-mato-qaops
cp .env.example .env
docker run --rm -v "$PWD":/app -w /app composer:2 install --ignore-platform-req=php
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail artisan storage:link
```

The app runs at <http://localhost>. Admin users are created in `/admin/users` (there is no public sign-up).

## Tests and checks (without Sail)

Only Docker is needed. Run from the project root.

First time:

```bash
cp .env.example .env
docker run --rm -v "$PWD":/app -w /app composer:2 install --ignore-platform-req=php
docker run --rm -v "$PWD":/app -w /app php:8.4-cli php artisan key:generate
```

- `composer:2` ships a newer PHP than the lockfile allows, hence `--ignore-platform-req=php`. The code itself runs on PHP 8.4.
- Tests always use SQLite in memory (forced in `phpunit.xml`), whatever database `.env` points to.

| Check | Command |
|---|---|
| Tests | `docker run --rm -v "$PWD":/app -w /app php:8.4-cli php artisan test` |
| Code style (Pint) | `docker run --rm -v "$PWD":/app -w /app php:8.4-cli vendor/bin/pint --test` |
| App boots (all routes load) | `docker run --rm -v "$PWD":/app -w /app php:8.4-cli php artisan route:list` |
| Dependencies | `docker run --rm -v "$PWD":/app -w /app composer:2 audit` |

To fix code style instead of only checking it: `vendor/bin/pint` (same container).

On Linux, add `-u "$(id -u):$(id -g)"` after `docker run --rm` so the generated files belong to your user.
