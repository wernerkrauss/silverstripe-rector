# Silverstripe 5.1.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/5/changelogs/5.1.0/#api-changes)

- [ ] [DEPRECATED] BuildTask now has boolean is_enabled configuration option which has precedence over the existing BuildTask::enabled protected class property. The BuildTask::enabled property has been marked as deprecated and will be removed in CMS 6 if favour of using is_enabled instead.
- [ ] Passing an argument for $limit that is not array|string|null in SilverStripe\ORM\Search\SearchContext::getQuery() will throw a deprecation warning. In CMS 6 the parameter type will be changed from dynamic to array|string|null.
- [ ] You can now declare the default case sensitivity used by SearchFilter implementations, which power the DataList filtering functionality. See search filter modifiers for more details.
- [ ] [DEPRECATED] The FileBlock::getSummaryThumbnail() method has been marked as deprecated and will be removed in CMS 6 without equivalent functionality to replace it, as it is no longer required for the elemental block's preview summary.
