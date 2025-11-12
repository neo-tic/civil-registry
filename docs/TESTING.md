## Testing strategy

The project ships with 3 complementary test layers executed through `php bin/phpunit`.

### 1. Unit tests (`tests/Unit`)

Focus on isolated services and helpers.

- `CivilRegistryServiceTest` – verifies validation, repository interaction, and DTO generation.
- `NniValidatorTest` – ensures strict 10-digit validation and normalisation behaviour.

### 2. Integration tests (`tests/Integration`)

Boot the Symfony kernel and the Doctrine entity manager to validate persistence logic.

- `CitizenFixturesTest` – loads the real data fixtures and asserts:
  - Total record count (100 citizens).
  - Gender parity (50/50).
  - Age distribution matches the specification.

### 3. Functional tests (`tests/Functional`)

Drive the HTTP layer end-to-end via `KernelBrowser`.

- `CivilRegistryApiTest` checks:
  - Successful lookups in French, Arabic, and dual-language modes.
  - Proper JSON structure and metadata.
  - Localised error payloads for invalid NNIs and unknown records.

### Test database lifecycle

- `DatabaseTestCase` and the functional test base rebuild the SQLite schema before each test using Doctrine’s `SchemaTool`.
- Fixtures are reloaded for deterministic datasets (`CitizenFixtures`).
- Test data lives in `var/data_test.db`, which is safe to delete between runs.

### Running tests

```bash
php bin/phpunit              # default run
php bin/phpunit --testdox    # verbose, human-readable output
php bin/phpunit --filter CivilRegistry  # targeted suites
```

### Continuous integration tips

- Cache the Composer vendor directory to speed up pipelines.
- Run `php bin/console doctrine:migrations:migrate --env=test --no-interaction` if you switch storage providers.
- Enforce `failOnWarning=true` (already set in `phpunit.dist.xml`) to catch deprecations early.

### Code coverage

PHPUnit 12 comes with native PCOV/Xdebug support. Enable one of the coverage drivers and pass `--coverage-html build/coverage` if coverage reports are required.

