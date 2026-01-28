# Silverstripe Rector Development Guidelines

This project provides Rector rules for Silverstripe CMS. Development is carried out using DDEV and follows the Test-Driven Development (TDD) approach.

## Language Standards

- All code, including variable names, method names, and comments, must be written in English.
- Documentation and commit messages should also be in English.
- Line length should not exceed 120 characters.

## Development Environment (DDEV)

- All PHP commands must be executed via DDEV.
- Use the commands defined in `.junie.json`:
    - `ddev phpunit` for tests.
    - `ddev lint` for code checks.
    - `ddev fix` for automatic fixes.
    - `ddev stan` for PHPStan analyses.
    - `ddev ci` for a full CI run before completing a task.

## Test-Driven Development (TDD)

- Before making code changes to Rectors, a corresponding test (usually a fixture) must be created or adapted.
- The test must reproduce the bug or the desired behavior and initially fail.
- Only after the failing test is established, the implementation is carried out until the test passes.

## Rector Rules

- New Rector rules should be placed in `src/Rector` in appropriate subdirectories.
- Tests are located in `tests/Rector` (or the corresponding structure in `tests`).
- Ensure the correct use of Silverstripe stubs in `stubs/`.

## Quality Assurance

- Run at least `ddev ci` before every `submit` to ensure no regressions have been introduced and the code meets the standards.
