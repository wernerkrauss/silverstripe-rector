# silverstripe-rector
A developer utility for automatically upgrading deprecated code for Silverstripe CMS

# WIP currently collecting ideas what to automate

## About rector

`rector` is a tool for automatic code upgrades and refactorings. See [rector homepage](https://getrector.org/) for more information.

## Installation

This module is installable via composer. As rector uses phpstan, it's a good idea to install `syntro/silverstripe-phpstan`, too.

```
composer require syntro/silverstripe-phpstan --dev
composer require rector/rector --dev
composer require wernerkrauss/silverstripe-rector --dev
vendor/bin/rector init
```

Create a basic phpstan.neon file in your project root:

```yaml
includes:
    - vendor/syntro/silverstripe-phpstan/phpstan.neon
```

This will add all requirements and create a file called `rector.php` in your project root. You'll need to adjust it, e.g. add the code directories to upgrade and the rules to use.

A basic rector config can look like

```php
<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\DataObject\EnsureTableNameIsSetRector;
use Netwerkstatt\SilverstripeRector\Rector\Injector\UseCreateRector;
use Netwerkstatt\SilverstripeRector\Rector\Misc\AddConfigPropertiesRector
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app/_config.php',
        __DIR__ . '/app/src',
    ]);
    $rectorConfig->autoloadPaths([
        //composer autoload is already loaded
    ]);
    //add needed files from modules, that don't support composer autoload yet
    $rectorConfig->bootstrapFiles([
        __DIR__ . '/vendor/path/to/code/Foobar.php'
    ]);



//    // register a single rule
    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

//    // define sets of rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_74,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE
    ]);

    //Silverstripe rules
    $rectorConfig->rule(EnsureTableNameIsSetRector::class);
    $rectorConfig->rule(UseCreateRector::class);
    
    $rectorConfig->ruleWithConfiguration(
        AddConfigPropertiesRector::class,
        [
            MyClass::class => [
                'my_config', 
                'another_config'
            ]
        ]
    );
};
```

## Running rector

Once it's configured, you can run rector in the command line using the following command:

```bash
vendor/bin/rector --dry-run 
```

The option `--dry-run` prints the code changes; if you're happy with the changes you can remove that option and rector will actually change the files.

### Useful options:

  - `--debug` for debugging verbosity. Which files and rules are processed?
  - `--xdebug` switch that allows running xdebug.

See `vendor/bin/rector --help` for more options.

# TODO

## SS3 to SS4 upgrades (before running official upgrader tool)
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

## SS4 upgrades
- [X] add `$table_name` if missing - use short classname instead
  - see similar [UnifyModelDatesWithCastsRector](https://github.com/rectorphp/rector-laravel/blob/main/src/Rector/Class_/UnifyModelDatesWithCastsRector.php)
- [ ] various deprecations
  - can be configured manually in set lists
- [ ] fix missing `$owns` for Image and File relations
  - [ ] configurable exclude list if it's not wanted
  - [ ] configurable which relations should be automatically owned (e.g. other versioned DataObjects)

## General
- [X] convert `new Foo()` to `Foo::create()` if it's a Silverstripe / Injectable class
  - see [NewToStaticCallRector](https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md#newtomethodcallrector)
- [ ] add `@config` param to `$db`, `$has_one`, etc.
- [ ] use Request handler instead of superglobal $_GET and $_POST

- [ ] create SetLists for easier configuration