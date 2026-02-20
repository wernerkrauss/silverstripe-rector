# Silverstripe 4.1.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.1.0/#api-changes)

- [ ] [RENAME/MOVE] SilverStripe\ORM\DataObject::get_by_id() is deprecated, use DataObject::get_by_id($class, $id) instead (already deprecated but listed)
- [ ] [DEPRECATED] SilverStripe\Core\Config\Config::inst() is deprecated, use SilverStripe\Core\Injector\Injector::inst()->get(Config::class) instead.
- [ ] [DEPRECATED] SilverStripe\Security\Member::backUrl() is deprecated.
- [ ] [REMOVED] SilverStripe\ORM\DB::getConn() has been removed in favor of DB::get_conn().

# Silverstripe 4.2.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.2.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\Control\HTTPRequest::param() is deprecated, use getVars() instead.
- [ ] [RENAME/MOVE] SilverStripe\ORM\DataObject::database_fields() renamed to DataObject::getSchema()->fieldSpecs().

# Silverstripe 4.3.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.3.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\ORM\DataObject::aggregate() is deprecated.
- [ ] [RENAME/MOVE] SilverStripe\ORM\DB::query() replaced by DB::prepared_query().

# Silverstripe 4.4.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.4.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\ORM\FieldType\DBField::prepValueForDB() is deprecated.
- [ ] [DEPRECATED] SilverStripe\Control\Controller::handleAction() changed signature.

# Silverstripe 4.5.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.5.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\ORM\Queries\SQLSelect::addGroupBy() is deprecated.
- [ ] [DEPRECATED] SilverStripe\Forms\FormField::setRightTitle() is deprecated.

# Silverstripe 4.6.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.6.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\ORM\DataObject::map() is deprecated, use DataList::map() instead.
- [ ] [DEPRECATED] SilverStripe\Security\Security::permissionFailure() changed signature.

# Silverstripe 4.7.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.7.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\View\Requirements::combine_files() is deprecated.
- [ ] [DEPRECATED] SilverStripe\ORM\DataObject::validate() now returns a ValidationResult.

# Silverstripe 4.8.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.8.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\Core\ClassInfo::subclassesFor() is deprecated, use getSubclassesFor() instead.
- [ ] [DEPRECATED] SilverStripe\ORM\DataList::unique() is deprecated.

# Silverstripe 4.9.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.9.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\Control\Email\Email::send() changed signature.
- [ ] [DEPRECATED] SilverStripe\Forms\GridField\GridFieldExportButton::generateExportFileData() is deprecated.

# Silverstripe 4.10.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.10.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\Control\Session::get_all() is deprecated.
- [ ] [DEPRECATED] SilverStripe\ORM\DataObject::i18n_plural_name() is deprecated.

# Silverstripe 4.11.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.11.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\Security\Member::generateAutologinToken() is deprecated.
- [ ] [DEPRECATED] SilverStripe\Forms\HTMLEditor\HTMLEditorField::setRows() is deprecated.

# Silverstripe 4.12.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/4/changelogs/4.12.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\ORM\FieldType\DBDate::Nice() changed default format.
- [ ] [DEPRECATED] SilverStripe\Forms\GridField\GridField_FormAction::getAttributes() is deprecated.
