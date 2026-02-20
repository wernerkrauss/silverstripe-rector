[![Latest Stable Version](http://poser.pugx.org/wernerkrauss/silverstripe-rector/v)](https://packagist.org/packages/wernerkrauss/silverstripe-rector) 
[![Total Downloads](http://poser.pugx.org/wernerkrauss/silverstripe-rector/downloads)](https://packagist.org/packages/wernerkrauss/silverstripe-rector) 
[![Latest Unstable Version](http://poser.pugx.org/wernerkrauss/silverstripe-rector/v/unstable)](https://packagist.org/packages/wernerkrauss/silverstripe-rector) 
[![License](http://poser.pugx.org/wernerkrauss/silverstripe-rector/license)](https://packagist.org/packages/wernerkrauss/silverstripe-rector) 
[![PHPunit](https://github.com/wernerkrauss/silverstripe-rector/actions/workflows/phpunit.yml/badge.svg)](https://github.com/wernerkrauss/silverstripe-rector/actions/workflows/phpunit.yml)

# silverstripe-rector
A developer utility for automatically upgrading deprecated code for Silverstripe CMS. With rules for upgrades for Silverstripe 6.

## Table of Contents
- [About rector](#about-rector)
- [Installation](#installation)
- [Running rector](#running-rector)
- [Docs](#docs)
- [IDE Support (PHPStorm)](#ide-support-phpstorm)
- [Other useful modules you should know about](#other-useful-modules-you-should-know-about)
- [Developing](#developing)
- [TODO](#todo)
- [Thanks to](#thanks-to)
- [Need Help?](#need-help)

## About rector

`rector` is a tool for automatic code upgrades and refactorings. See [rector homepage](https://getrector.org/) for more information.

## Installation

This module is installable via composer. As Rector uses PHPstan, it's a good idea to install `cambis/silverstan`, too.

> Note: if you need to use PHPStan v1 in your project, use v0.x of this module

```bash
composer require phpstan/extension-installer --dev
composer require cambis/silverstan  --dev
composer require wernerkrauss/silverstripe-rector --dev
vendor/bin/rector init
```

Create a basic `phpstan.neon` file in your project root:

```yaml
parameters:
  level: 1
  paths:
    - app/src
```

This will add all requirements and create a file called `rector.php` in your project root. You'll need to adjust it, e.g. add the code directories to upgrade and the rules to use.

A basic Rector config can look like

```php
<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Set\SilverstripeLevelSetList;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        instanceOf: true,
        earlyReturn: true,
        rectorPreset: true
    )
    ->withPhpSets() //automatically gets the PHP version from composer.json
    ->withSets([
        //silverstripe rector
        SilverstripeSetList::CODE_STYLE,
        SilverstripeLevelSetList::UP_TO_SS_6_0
    ]);

```

Silverstripe-rector comes with two types of SetLists: `SilverstripeSetList` for single sets of rectors (e.g. upgrading from 5.0 to 5.1 or for general Silverstripe code styles) and `SilverstripeLevelSetList` for combining all set lists up to a given Silverstripe CMS version, e.g. running all upgrades to Silverstripe 5.1.

See also [Rector documentation](https://getrector.com/documentation) for more configuration possibilities.

You can find a [list of Rectors provided by this module](./docs/all_rectors_overview.md) in the documentation.

## Running rector

Once it's configured, you can run Rector in the command line using the following command:

```bash
vendor/bin/rector --dry-run 
```

The option `--dry-run` prints the code changes; if you're happy with the changes, you can remove that option and rector will actually change the files.

### Useful options:

  - `--debug` for debugging verbosity. Which files and rules are processed?
  - `--xdebug` switch that allows running xdebug.

See `vendor/bin/rector --help` for more options.

## Docs
* [Changelog](./CHANGELOG.md)
* See a [list of custom Silverstripe related rectors](./docs/all_rectors_overview.md) in the docs.

* [Update from Silverstripe 5 to Silverstripe 6](https://www.s2-hub.com/articles/update-from-silverstripe-5-to-silverstripe-6/): article on s2-hub.com
* [Better PHP with rector](https://www.youtube.com/watch?v=ORYlXK7I6Dw): Talk at StripeConEU 2023 in Hamburg

## Changelog Analysis Process

To keep up with new Silverstripe releases, we use an AI-assisted workflow:

1.  **Sync Changelogs**: Download both HTML (for reference) and Markdown (for analysis) files.
    ```bash
    ddev changelog-sync 6.2.0
    ```
2.  **Generate AI Prompt**: This script extracts the most relevant sections (API changes, renames, deprecations) from the Markdown file.
    ```bash
    ddev changelog-analyze-ai 6.2.0
    ```
3.  **Process with AI**: Copy the generated prompt into an AI (like ChatGPT or Claude).
4.  **Update TODOs**: Copy the AI's response into `docs/todos/ss-X.Y.Z.md`.

Standard TODO Format:
- `[RENAME/MOVE] Old\Namespace\Class has been renamed to New\Namespace\Class`
- `[DEPRECATED] Method OldClass::method() is deprecated, use NewClass::method() instead`
- `[REMOVED] Class/Method ... has been removed.`

## IDE Support (PHPStorm)

Since Rector uses PHPStan, which is often distributed as a PHAR file, your IDE might not find classes like `PHPStan\Type\ObjectType`.

To fix this in PHPStorm:

1. **Include PHPStan classes**:
   - Go to `Settings` > `Languages & Frameworks` > `PHP`.
   - In the **Include Path** tab, click `+`.
   - Add the directory `vendor/phpstan/phpstan`. PHPStorm will automatically find and index the `phpstan.phar` inside it.
   - *Alternatively*: Install the `phpdoc-parser` which provides many type definitions:
     ```bash
     composer require --dev phpstan/phpdoc-parser
     ```

2. **Exclude fixtures**:
   To avoid "Duplicate class" errors from test fixtures, exclude the `tests/**/Fixture` directories from your project:
   - Right-click on the `Fixture` folder in the project tree.
   - Select `Mark Directory as` > `Excluded`.

## Other useful modules you should know about
* [cambis/silverstripe-rector](https://packagist.org/packages/cambis/silverstripe-rector)

## Developing
This module is preconfigured to run with ddev and has some useful custom scripts for developing:

### PHP Code Sniffer

Code Sniffer is a tool to detect violations of a defined coding standard (mostly PSR-12)

See phpcs.xml.dist for the ruleset used.

Detect violations

```bash
ddev composer run lint
```

or
```bash
ddev lint
```

Fix most violations automatically
```bash
ddev composer run fix
```

or the shortcut
```bash
ddev fix
```

### PHPStan
PHP Static Code Analyzer is a tool to detect bugs in your code without running it. It can be used to detect type errors, dead code, and other issues.

Don't be too much annoyed by the errors. Rector can fix a lot of them automatically.

A level of 4 should be doable.

```bash
ddev composer run phpstan
```

or
```bash
ddev stan
```

### Rector
Rector is a tool to refactor code automatically. It can be used to upgrade code to a newer version of Silverstripe or PHP.

See rector.php for rules and configuration.

```bash 
ddev composer run rector-dry #dry run
ddev composer run rector
```

or
```bash
ddev rector --dry-run #dry-run
ddev rector 
```

### Everything in one command

There is also a CI tool to run everything in one command

```bash
ddev ci
```

## TODO

### SS3 to SS4 upgrades (before running official upgrader tool)
- [ ] rename `Foo_Controller` to `FooController`
  - how can this be made dynamically? via config script that scans the current project?
- [ ] configure PSR4 Class To File
- [ ] maybe add namespace to `src` dir
- [ ] various deprecations.
  -  Is it possible to automate stuff that was once configured in PHP and is now configured in YML?
  -  easy fix would be to switch to new config layer in PHP and add an annotation to fix this manually
- [ ] fix old `Image` functions in templates that got deprecated in SS3.2
  - this needs another file parser for Silverstripe templates
- [X] class `Object` to trait, see [ParentClassToTraitsRector](https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md#parentclasstotraitsrector)

### SS4 upgrades
- [X] add `$table_name` if missing - use short classname instead
  - see similar [UnifyModelDatesWithCastsRector](https://github.com/rectorphp/rector-laravel/blob/main/src/Rector/Class_/UnifyModelDatesWithCastsRector.php)
- [ ] various deprecations
  - to be configured manually in set lists
- [ ] fix missing `$owns` for Image and File relations
  - [ ] configurable exclude list if it's not wanted
  - [ ] configurable which relations should be automatically owned (e.g. other versioned DataObjects)

### General
#### Misc
- [X] create SetLists for easier configuration

#### Code Quality
- [X] convert `new Foo()` to `Foo::create()` if it's a Silverstripe / Injectable class
  - see [NewToStaticCallRector](https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md#newtomethodcallrector)
- [X] add `@config` param to `$db`, `$has_one`, etc.
- [X] use array notation for `->filter`, `->extend` and `->sort()`
- [ ] use Request handler instead of superglobal `$_GET` and `$_POST`

## Thanks to
[xini](https://github.com/xini) for updating this module to Rector V2 and adding a lot of Silverstripe 6 rules.

## Need Help?

If you need some help with your Silverstripe project, feel free to [contact me](mailto:werner.krauss@netwerkstatt.at) ✉️.

See you at next [StripeCon](https://stripecon.eu) 👋
