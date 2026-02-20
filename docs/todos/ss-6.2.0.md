# Silverstripe 6.2.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/6/changelogs/6.2.0/#api-changes)

- [ ] [DEPRECATED] SilverStripe\ORM\DataList::getIDList() is deprecated. Use $list->sort(null)->column('ID') instead.
- [ ] [DEPRECATED] SilverStripe\ORM\Relation::getIDList() is deprecated. Use $list->sort(null)->column('ID') instead.
- [ ] [DEPRECATED] SilverStripe\ORM\EagerLoadedList::getIDList() is deprecated. Use $list->column('ID') instead.
- [ ] [DEPRECATED] SilverStripe\ORM\UnsavedRelationList::getIDList() is deprecated. Use $list->column('ID') instead.
- [ ] [DEPRECATED] SilverStripe\Forms\FieldList::dataFields() is deprecated. Use SilverStripe\Forms\FieldList::getDataFields() instead.
- [ ] [DEPRECATED] Template tag <% base_tag %> is deprecated. Remove usage in templates.
