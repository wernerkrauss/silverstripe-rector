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
- **Fixture Structure**:
    - Use exactly **one fixture file per test case**.
    - Give fixtures descriptive names (e.g., `simple_if_has_curr.php.inc`, `negated_if_has_curr.php.inc`).
    - Avoid large, monolithic fixture files containing multiple unrelated scenarios.
- **Negative Testing**:
    - Always include **negative tests** (usually prefixed with `skip_`) to ensure the Rector does not produce false positives (e.g., `skip_other_classes.php.inc`).
    - Verify that the Rector only affects the intended classes and methods.

## Rector Rules

- New Rector rules should be placed in `src/Rector` in appropriate subdirectories.
- Tests are located in `tests/Rector` (or the corresponding structure in `tests`).
- Ensure the correct use of Silverstripe stubs in `stubs/`.
- **Documentation**: 
    - Include the Silverstripe version or setlist in the rule definition's description (e.g., "Silverstripe 6.0: ...").
    - After creating or modifying a Rector, update the documentation by running `ddev composer docs:generate`.

## Quality Assurance

- Run at least `ddev ci` before every `submit` to ensure no regressions have been introduced and the code meets the standards.

## Troubleshooting

- If a new stub class in `stubs/` is not being found, run `ddev composer dump-autoload` and try again.

## Changelog Guidelines

- The project uses a `CHANGELOG.md` following the [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) format.
- Adhere to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).
- **External Contributors**: Always mention external contributors (non-Dependabot) with their GitHub handle (e.g., `(thanks to [@username](https://github.com/username))`).
- **Issue Tracking**: Check if a commit fixes an issue (look for "fixes #123" or similar in commit messages) and link it in the changelog.
- **Breaking Changes**: Clearly mark breaking changes and mention any incompatibilities (e.g., with specific `rector/rector` versions).
- **Language**: Changelog entries must be written in English.
- **Line Length**: Ensure lines in `CHANGELOG.md` do not exceed 120 characters.
