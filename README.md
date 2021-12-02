# silverstripe-rector
A developer utility for automatically upgrading deprecated code for Silverstripe CMS

# WIP currently collecting ideas what to automate

## SS3 to SS4 upgrades (before running official upgrader tool)
- [ ] rename `Foo_Controller` to `FooController`
- [ ] configure PSR4 Class To File
- [ ] maybe add namespace to `src` dir
- [ ] various deprecations.
  -  Is it possible to automate stuff that was once configured in PHP and is now configured in YML?
  -  easy fix would be to switch to new config layer in PHP and add an annotation to fix this manually
- [ ] fix old `Image` functions in templates that got deprecated in SS3.2
  - this needs another file parser for Silverstripe templates

## SS4 upgrades
- [ ] add `$table_name` if missing - use short classname instead
- [ ] various deprecations

## General
- [ ] convert `new Foo()` to `Foo::create()` if it's a Silverstripe / Injectable class
