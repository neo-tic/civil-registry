<div align="center">

# Civil Registry API — Simulation System

_A multilingual Symfony REST API that emulates a Mauritanian civil registry for prototyping and testing purposes._

</div>

> **Disclaimer**  
> All person records, names, locations, and identification numbers provided by this project are entirely fictitious.  
> This software is not affiliated with, endorsed by, or connected to any government entity.

## Table of contents

1. [Project overview](#project-overview)  
2. [Stack & prerequisites](#stack--prerequisites)  
3. [Getting started](#getting-started)  
4. [Database & fixtures](#database--fixtures)  
5. [Running tests](#running-tests)  
6. [API usage](#api-usage)  
7. [Project structure](#project-structure)  
8. [Maintenance commands](#maintenance-commands)  
9. [Further documentation](#further-documentation)  

---

## Project overview

The **Civil Registry API** simulates the lookup capabilities of a national civil registry.  
It exposes a single, versioned endpoint that returns citizen records in **French** and **Arabic**, allowing consumers to prototype integrations with multilingual datasets, localized error handling, and realistic population distributions.

Key features:

- Symfony 7 REST API with PSR-compliant code style.
- Doctrine ORM with structured entities and repositories.
- Service layer encapsulating validation, localization, and business logic.
- Comprehensive error model with bilingual messages.
- Deterministic data fixtures (100 citizens) respecting gender and age distributions.
- Extensive automated test suite (unit + integration + functional).

## Stack & prerequisites

| Requirement | Version / Notes |
|-------------|-----------------|
| PHP         | 8.2 or higher (8.4 tested) with SQLite extension enabled |
| Composer    | 2.6+ |
| SQLite      | Bundled with PHP; ensure `pdo_sqlite` is enabled |
| Symfony CLI | _Optional_ – useful for local web server (`symfony serve`) |

The application defaults to SQLite databases for every environment via `config/packages/{dev,test}/doctrine.yaml`.  
To use PostgreSQL, MySQL, or another RDBMS, override `DATABASE_URL` in your `.env.local`.

## Getting started

```bash
# 1. Install dependencies
composer install

# 2. Generate the SQLite database schema
php bin/console doctrine:migrations:migrate --no-interaction

# 3. Load the simulation dataset (100 citizens)
php bin/console doctrine:fixtures:load --no-interaction

# 4. (Optional) Run the built-in Symfony web server
symfony serve --dir=public
```

The API will be reachable at `http://127.0.0.1:8000/api/v1/civil-register/{nni}`.

## Database & fixtures

The SQLite database files live in `var/`:

- Development: `var/data_dev.db`
- Test: `var/data_test.db` (rebuilt automatically during test runs)

Fixtures are deterministic and meet the specification:

- **100 citizens** split across Mauritanian regions.
- **Gender parity**: exactly 50 male, 50 female.
- **Age distribution**: 20% minors (<18), 60% adults (18–50), 20% seniors (>50).
- **Multilingual fields**: every textual attribute is stored in both French (`*_fr`) and Arabic (`*_ar`) columns.
- Realistic Mauritanian first names, patronyms, and districts.

See [`docs/DATABASE.md`](docs/DATABASE.md) for the full schema overview.

## Running tests

```bash
# Execute the full suite (unit + integration + functional)
php bin/phpunit
```

The test bootstrap rebuilds the test database from metadata and reloads fixtures to ensure consistent runs.

Continuous integration recommendations:

```bash
composer validate
php bin/console doctrine:migrations:migrate --env=test --no-interaction
php bin/phpunit --testdox
```

## API usage

The API exposes a single read-only endpoint:

```
GET /api/v1/civil-register/{nni}?lang={fr|ar|both}
```

| Parameter | Type   | Description | Default |
|-----------|--------|-------------|---------|
| `nni`     | string | Mauritanian National Identification Number (10 digits) | – |
| `lang`    | string | `fr`, `ar`, or `both` | `fr` |

Success response (200):

```json
{
  "data": {
    "nni": "1200000000",
    "first_name": "Mohamed",
    "last_name": "Ould Ahmed",
    "gender": "Masculin",
    "date_of_birth": "1990-04-01",
    "place_of_birth": "Nouakchott",
    "marital_status": "Marié(e)",
    "nationality": "Mauritanienne",
    "address": "Quartier Tevragh-Zeina, Nouakchott, Mauritanie"
  },
  "meta": {
    "language": "fr",
    "retrieved_at": "2025-11-12T16:45:00+00:00",
    "source": "Civil Registry API Simulation – Not an official government service",
    "disclaimer": {
      "fr": "Données fictives fournies uniquement à des fins de test et de prototypage. Ce service n’est pas affilié au gouvernement mauritanien.",
      "ar": "البيانات الواردة وهمية ومخصصة للاختبار والنمذجة فقط. هذه الخدمة غير تابعة للحكومة الموريتانية."
    }
  }
}
```

Switch `lang=ar` for Arabic-only values, or `lang=both` to receive bilingual payloads per field.

Error responses follow a consistent contract with localized messages. Example:

```json
{
  "error": {
    "status": 400,
    "code": "INVALID_NNI_FORMAT",
    "message": {
      "fr": "Le format du Numéro National d’Identification (NNI) est invalide. Il doit contenir exactement 10 chiffres.",
      "ar": "تنسيق الرقم الوطني للتعريف غير صالح. يجب أن يتكون من 10 أرقام بالضبط."
    },
    "details": {
      "nni": "ABC"
    }
  },
  "meta": {
    "disclaimer": {
      "fr": "Données fictives fournies uniquement à des fins de test et de prototypage.",
      "ar": "البيانات الواردة وهمية ومخصصة للاختبار والنمذجة فقط."
    },
    "timestamp": "2025-11-12T16:50:24+00:00"
  }
}
```

Full request / response documentation with additional samples is available in [`docs/API.md`](docs/API.md).

## Project structure

```
civil-registry-api/
├── config/               Symfony configuration (routing, services, doctrine, etc.)
├── docs/                 Extra documentation (API, database schema)
├── migrations/           Doctrine migrations
├── src/
│   ├── Controller/       HTTP controllers (REST endpoints)
│   ├── DataFixtures/     Doctrine fixtures (100 citizens)
│   ├── Dto/              Response DTOs
│   ├── Enum/             Language enumeration
│   ├── Entity/           Doctrine entities
│   ├── EventSubscriber/  API exception formatting
│   ├── Exception/        Domain-specific exceptions
│   ├── Repository/       Doctrine repositories
│   ├── Service/          Business logic & orchestration
│   └── Validator/        Input validation helpers
├── tests/                Unit, integration, and functional tests
└── var/, vendor/         Runtime cache and dependencies (generated)
```

## Maintenance commands

Quick reference for daily operations:

```bash
# Generate a new migration after changing entities
php bin/console make:migration

# Run pending migrations
php bin/console doctrine:migrations:migrate

# Reset database & reload fixtures (development)
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction

# Run static analysis / code style (suggested)
composer validate
php bin/phpunit --testdox
```

## Further documentation

- [`docs/API.md`](docs/API.md) – Endpoint specification with cURL examples.
- [`docs/DATABASE.md`](docs/DATABASE.md) – Schema diagram & data distribution notes.
- [`docs/TESTING.md`](docs/TESTING.md) – Test strategy, suites, and coverage notes.

For questions, improvements, or issues, please open a ticket in the repository and provide as much detail as possible.

