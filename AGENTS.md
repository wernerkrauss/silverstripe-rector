# AGENTS.md — Guidance for AI coding agents (Mistral Code, Junie, etc.)

This repo is **wernerkrauss/silverstripe-rector**: Rector rules and set lists for
automatically upgrading deprecated code in Silverstripe CMS projects (SS4 → SS6).

## Read first

- **Full development guidelines:** [`.ai/guidelines.md`](.ai/guidelines.md)
  (TDD, fixture structure, setlist testing, changelog rules) — these apply to all
  AI agents working in this repo.
- **Environment specifics (WSL2/DDEV):** [`.ai/guidelines/Environment.md`](.ai/guidelines/Environment.md)
- **Trusted commands:** `.ai.json` (test, lint, fix, stan, ci — via DDEV locally)

## Project layout

- `config/silverstripe-X-Y.php` — set lists per CMS minor version
- `config/level/` — "up to version X" level sets
- `src/Rector/` — custom Rector rules
- `src/Set/` — `SilverstripeSetList` / `SilverstripeLevelSetList` (public API, do not remove constants)
- `src/PHPStan/` — PHPStan helpers used by the rectors
- `stubs/` — stub classes for symbols not resolvable via composer
- `tests/` — PHPUnit tests (one fixture file per test case, `skip_` fixtures for negative tests)
- `docs/todos/` — per-version TODO lists derived from the Silverstripe changelogs

## Commands

Locally (DDEV) use the commands from `.ai.json`:

```bash
ddev phpunit     # tests
ddev lint        # style checks
ddev fix         # auto-fix style
ddev stan        # PHPStan
ddev ci          # full CI run before completing a task
```

In CI or environments without DDEV:

```bash
composer install
vendor/bin/phpunit
vendor/bin/phpstan analyse
vendor/bin/phpcs
```

## Conventions (summary — details in .ai/guidelines.md)

- Follow TDD: failing test/fixture first, then implementation.
- New rename/class-change rules belong in the matching `config/silverstripe-X-Y.php`
  and must be covered by a setlist test in `tests/Set/SilverstripeXY/`.
- Verify a rule actually exists in the target Silverstripe version before adding a
  rename — check the official changelog (https://docs.silverstripe.org/en/6/changelogs/)
  and, if unsure, the `silverstripe/framework` source. Wrong renames are worse than
  no renames.
- Keep `SilverstripeSetList` / `SilverstripeLevelSetList` backwards compatible.
- Run `ddev composer docs:generate` after creating or modifying a Rector.
- All code, comments and commit messages in English; max line length 120.

## AI-assisted tasks (Mistral Code)

- Remote: label an issue `ai-task` or comment `/ai` — see `.github/workflows/ai-task.yml`
  and `docs/ai-tasks.md`.
- Locally: `./scripts/ai-task.sh <issue-number | prompt>`.
- The existing changelog-based update workflow lives in `scripts/internal/` and
  `docs/todos/` (see README "AI-assisted workflow").
