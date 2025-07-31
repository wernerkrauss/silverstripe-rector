[![Latest Stable Version](http://poser.pugx.org/wernerkrauss/silverstripe-rector/v)](https://packagist.org/packages/wernerkrauss/silverstripe-rector) 
[![Total Downloads](http://poser.pugx.org/wernerkrauss/silverstripe-rector/downloads)](https://packagist.org/packages/wernerkrauss/silverstripe-rector) 
[![Latest Unstable Version](http://poser.pugx.org/wernerkrauss/silverstripe-rector/v/unstable)](https://packagist.org/packages/wernerkrauss/silverstripe-rector) 
[![License](http://poser.pugx.org/wernerkrauss/silverstripe-rector/license)](https://packagist.org/packages/wernerkrauss/silverstripe-rector) 
[![PHPunit](https://github.com/wernerkrauss/silverstripe-rector/actions/workflows/phpunit.yml/badge.svg)](https://github.com/wernerkrauss/silverstripe-rector/actions/workflows/phpunit.yml)

# silverstripe-rector
A developer utility for automatically upgrading deprecated code for Silverstripe CMS. With rules for upgrades for Silverstripe 6.

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

See a [list of custom Silverstripe related rectors](./docs/all_rectors_overview.md) in the docs.


## Other useful modules you should know about
* [cambis/silverstripe-rector](https://packagist.org/packages/cambis/silverstripe-rector)

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
- [ ] class `Object` to trait, see [ParentClassToTraitsRector](https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md#parentclasstotraitsrector)

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
- [ ] use Request handler instead of superglobal `$_GET` and `$_POST`

## Thanks to
[xini](https://github.com/xini) for updating this module to Rector V2 and adding a lot of Silverstripe 6 rules.

## Need Help?

If you need some help with your Silverstripe project, feel free to [contact me](mailto:werner.krauss@netwerkstatt.at) ✉️.

See you at next [StripeCon](https://stripecon.eu) 👋
