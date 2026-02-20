# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Added `StatToConfigGetRector` to replace `$this->stat()` with `static::config()->get()` for Silverstripe 4.
- Updated documentation to include Silverstripe version or setlist in rule descriptions.
- Added `ReplaceHasCurrWithCurrRector` to replace `Controller::has_curr()` with `Controller::curr() !== null` for Silverstripe 6.
- Added Silverstripe 6.0 Extension hook renames to the SS 6.0 setlist (thanks to [@lerni](https://github.com/lerni)).
- Added Silverstripe 6.0 class renames for `ViewableDataContains` and `DatabaseAdminExtension`.
- Added tests for Silverstripe 6.0 SetList

## [1.2] - 2026-01-28

### Added
- Added custom PHPStan rule `DocumentedRectorRule` to ensure all Rectors implement `DocumentedRuleInterface`.
- Added check in PHPStan rule to ensure configurable Rectors return `ConfiguredCodeSample`.
- Added `DataObjectGetByIdToByIDRector` to convert `DataObject::get_by_id()` to `DataObject::get()->byID()`.
  (fixes [#7](https://github.com/wernerkrauss/silverstripe-rector/issues/7))
- Added ORM Rectors to convert filter and sort arguments to array notation.
  (fixes [#12](https://github.com/wernerkrauss/silverstripe-rector/issues/12),
  [#2](https://github.com/wernerkrauss/silverstripe-rector/issues/2))

### Changed
- Updated `AddConfigPropertiesRector` to implement `DocumentedRuleInterface`.

## [1.1] - 2026-01-27

### Added
- Added GitHub CI test support for PHP 8.5.
- Added `RenameAddFieldsToTabWithoutArrayParamRector` to handle single field additions.
  (fixes [#26](https://github.com/wernerkrauss/silverstripe-rector/issues/26))
- Added `ParentClassToTraitsRector` and `PropertyFetchToMethodCallRector` as replacements for
  deprecated Rector core rules. (thanks to [@florian-thoma](https://github.com/florian-thoma))
- Added ddev commands for better development workflow.

### Changed
- **Breaking Change**: Minimum requirement for `rector/rector` is now `^2.3.4`.
  (thanks to [@florian-thoma](https://github.com/florian-thoma))
- Fixed `PropertyFetchToMethodCallRector` and added tests.
  (fixes [#36](https://github.com/wernerkrauss/silverstripe-rector/issues/36))
- Improved CI pipeline with ddev commands and linting checks.

## [1.0] - 2025-05-12

### Added
- Basic rules for Silverstripe 5.3 and 5.4 deprecations. ([@florian-thoma](https://github.com/florian-thoma))

### Changed
- Upgraded to Rector 2. ([@florian-thoma](https://github.com/florian-thoma))
- Updated tests to PHPUnit 11. ([@florian-thoma](https://github.com/florian-thoma))
- Upgraded ddev PHP version to 8.2.
- Documentation updates and improved README. (including contributions by [@sunnysideup](https://github.com/sunnysideup))
- Fixed typos and improved plug-n-play examples in README. ([@sunnysideup](https://github.com/sunnysideup))

## [0.2] - 2025-05-12

### Added
- Support for Silverstripe 6 class renames.

### Changed
- Improved `AddConfigPropertiesRector` with unique config per class and fixed classnames.
- Fixed deprecated creation of dynamic properties.
- Updated unit tests and PHP versions in CI.
- This is the last release vor Rector 1.

## [0.1.1] - 2024-10-21

### Changed
- Updated `@config` property configuration in `AddConfigPropertiesRector`.

## [0.1] - 2024-02-19

### Added
- Initial release with support for Rector 1.0. (fixes [#14](https://github.com/wernerkrauss/silverstripe-rector/issues/14))
- Added basic Silverstripe Rector rules.
- Included `PhpParser\Builder` directly for better compatibility. (fixes [#1](https://github.com/wernerkrauss/silverstripe-rector/issues/1))
