## Database schema & data model

The simulation uses a single `citizen` table managed through Doctrine ORM.  
SQLite is the default storage engine in both development and test environments.

### Entity overview

```text
citizen
├── id (INTEGER, PK, auto-increment)
├── nni (VARCHAR(10), unique)
├── first_name_fr (VARCHAR(120))
├── first_name_ar (VARCHAR(120))
├── last_name_fr (VARCHAR(120))
├── last_name_ar (VARCHAR(120))
├── gender_fr (VARCHAR(20))
├── gender_ar (VARCHAR(20))
├── date_of_birth (DATE, immutable)
├── place_of_birth_fr (VARCHAR(255))
├── place_of_birth_ar (VARCHAR(255))
├── marital_status_fr (VARCHAR(80))
├── marital_status_ar (VARCHAR(80))
├── nationality_fr (VARCHAR(120))
├── nationality_ar (VARCHAR(120))
├── address_fr (VARCHAR(255))
├── address_ar (VARCHAR(255))
├── created_at (DATETIME, immutable)
└── updated_at (DATETIME, immutable)
```

Key characteristics:

- Every textual column is duplicated for bilingual coverage (French `_fr`, Arabic `_ar`).
- `nni` is the business identifier and is strictly 10 digits.
- `created_at`/`updated_at` timestamps are automatically initialised; `updated_at` refreshes on updates via lifecycle callback.

### Fixtures

`App\DataFixtures\CitizenFixtures` constructs 100 deterministic citizens with:

| Dimension          | Specification                                             |
|--------------------|-----------------------------------------------------------|
| Count              | 100                                                       |
| Gender split       | 50 male / 50 female                                       |
| Age distribution   | 20 minors, 60 adults, 20 seniors                          |
| Locations          | Representative Mauritanian cities and districts           |
| Nationality        | Always Mauritanian (`Mauritanienne` / `موريتانية`)       |
| Marital status     | Weighted random (single, married, divorced, widowed)      |
| Address structure  | `Quartier {district}, {city}, Mauritanie` (Arabic mirror) |

The fixture uses curated lists of Mauritanian first names, patronyms, and communes to keep data culturally authentic while remaining fake.

### Age buckets

| Bucket  | Range (inclusive) | Records | Example DOB            |
|---------|-------------------|---------|------------------------|
| Minor   | `< 18 years`      | 20      | 2010-09-22             |
| Adult   | `18–50 years`     | 60      | 1995-04-18             |
| Senior  | `> 50 years`      | 20      | 1962-01-07             |

Birth dates are generated with `Faker` and stored as immutable dates, ensuring repeatable tests.

### Gender labels

| Key    | French    | Arabic |
|--------|-----------|--------|
| male   | Masculin  | ذكر    |
| female | Féminin   | أنثى   |

### Loading & resetting data

```bash
# Initial load
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction

# Rebuild from scratch
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
```

### Extending the schema

To add more attributes or additional entities:

1. Update or create Doctrine entities under `src/Entity`.
2. Generate a migration via `php bin/console make:migration`.
3. Review and run the migration.
4. Update fixtures and tests to reflect the new structure.

Remember to update the bilingual data requirements when introducing new textual fields.

