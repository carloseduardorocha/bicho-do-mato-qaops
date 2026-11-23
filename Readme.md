# Bicho do Mato

Website of the Bicho do Mato NGO: public pages (home, news, partners, testimonials) and an admin area. Laravel 12 + Blade (Bootstrap from a CDN, no front-end build), PHP 8.4.

[![CI](https://github.com/carloseduardorocha/bicho-do-mato-qaops/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/carloseduardorocha/bicho-do-mato-qaops/actions/workflows/ci.yml)

## Quality pipeline (DevOps/QAOps coursework, UFSM)

Every push and pull request to `main` runs [`.github/workflows/ci.yml`](.github/workflows/ci.yml): six quality gates (build, static analysis, tests, coverage, dependencies, secrets), each as its own job. A failed gate blocks the merge, and every run keeps its logs and reports as artifacts. Results: [Actions](https://github.com/carloseduardorocha/bicho-do-mato-qaops/actions/workflows/ci.yml).

Documentation (in Portuguese):

- [`docs/qaops/PLANO.md`](docs/qaops/PLANO.md): system, risks, gates, deliveries and team conventions
- [`docs/qaops/testes.md`](docs/qaops/testes.md): risk → test → type, and what was left out
- [`docs/qaops/gates.md`](docs/qaops/gates.md): the record of each gate (criterion, rationale, evidence, consequence, limits)
- [`docs/qaops/experimento.md`](docs/qaops/experimento.md): approved, rejected and fixed runs, compared

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

The app runs at <http://localhost>. There is no public sign-up: the seed creates the first admin, and the others are created in `/admin/users`.

- Admin login: `SEED_ADMIN_EMAIL` from `.env` (`admin@example.com` by default). Set `SEED_ADMIN_PASSWORD` before seeding, or leave it empty and copy the random password printed by `migrate:fresh --seed`. No password is stored in the repository.

- `.env.example` is ready for Sail: the database is the `mysql` container, with local-only credentials.
- If port 80 or 3306 is taken, set `APP_PORT` and `FORWARD_DB_PORT` in `.env` (e.g. `8080` and `3307`) before `sail up`.
- Stop with `./vendor/bin/sail down` (add `-v` to also drop the database).

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
| Static analysis (Larastan, level 5) | `docker run --rm -v "$PWD":/app -w /app php:8.4-cli vendor/bin/phpstan analyse --memory-limit=1G` |
| App boots (all routes load) | `docker run --rm -v "$PWD":/app -w /app php:8.4-cli php artisan route:list` |
| Dependencies | `docker run --rm -v "$PWD":/app -w /app composer:2 audit` |
| Coverage (PCOV, `app/Services`, HTML in `reports/coverage-html`) | `docker run --rm -v "$PWD":/app -w /app php:8.4-cli sh -c 'pecl install pcov && docker-php-ext-enable pcov && php artisan test --coverage-html reports/coverage-html'` |
| Secrets (Gitleaks, whole git history) | `docker run --rm -v "$PWD":/repo:ro ghcr.io/gitleaks/gitleaks:v8.30.1 git /repo --redact` |

To fix code style instead of only checking it: `vendor/bin/pint` (same container).

On Linux, add `-u "$(id -u):$(id -g)"` after `docker run --rm` so the generated files belong to your user (except for coverage: installing PCOV needs root).
