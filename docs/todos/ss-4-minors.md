# Silverstripe 4.1.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.1.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\Core\Config\Config::inst() is deprecated, use SilverStripe\Core\Injector\Injector::inst()->get(Config::class) instead.
- [ ] [REMOVED] SilverStripe\ORM\DB::getConn() has been removed in favor of DB::get_conn().

# Silverstripe 4.2.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.2.0/#api-changes)

- [ ] [RENAME/MOVE] SilverStripe\ORM\DataObject::database_fields() renamed to DataObject::getSchema()->fieldSpecs().

# Silverstripe 4.3.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.3.0/#api-changes)


# Silverstripe 4.4.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.4.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\ORM\FieldType\DBField::prepValueForDB() is deprecated.

# Silverstripe 4.5.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.5.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\Forms\FormField::setRightTitle() is deprecated.

# Silverstripe 4.6.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.6.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\ORM\DataObject::map() is deprecated, use DataList::map() instead.

# Silverstripe 4.7.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.7.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\View\Requirements::combine_files() is deprecated.
- [ ] [DEPRECATED] SilverStripe\ORM\DataObject::validate() now returns a ValidationResult.

# Silverstripe 4.8.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.8.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\ORM\DataList::unique() is deprecated.

# Silverstripe 4.9.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.9.0/#api-changes)

# Silverstripe 4.10.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.10.0/#api-changes)

- [x] [DEPRECATED] SilverStripe\ORM\DataObject::i18n_plural_name() is deprecated.

# Silverstripe 4.11.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.11.0/#api-changes)


# Silverstripe 4.12.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.12.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\ORM\FieldType\DBDate::Nice() changed default format.
- [ ] [DEPRECATED] SilverStripe\Forms\GridField\GridField_FormAction::getAttributes() is deprecated.
