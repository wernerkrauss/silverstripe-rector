# Silverstripe 5.3.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/5/changelogs/5.3.0/#api-changes)

- [ ] [DEPRECATED] Passing a non-array $fields argument to both FieldList::addFieldsToTab() and FieldList::removeFieldsFromTab() has been deprecated.
- [ ] [DEPRECATED] The BaseElement::getDescription() method has been deprecated. To update or get the CMS description of elemental blocks, use the description configuration property and the localisation API.
- [ ] [DEPRECATED] The RememberLoginHash::renew() method has been deprecated without replacement, since the associated behaviour will be removed in 6.0. The onAfterRenewToken extension point within this method will likely be replaced with a new extension point in 6.0.
- [ ] [REMOVED] The RememberLoginHash.replace_token_during_session_renewal configuration property has been added to allow disabling token regeneration during session renewal. This property will be removed in 6.0.
- [ ] [DEPRECATED] Code for the CMS GraphQL admin schema which provided endpoints for the CMS has been deprecated and will be removed in CMS 6. Functionality which the GraphQL endpoints are currently responsible for will be replaced with regular Silverstripe controller endpoints instead. Extension hooks will be added to the new controller endpoints that return data to allow for customisation. Frontend schemas, such the default schema, will continue to work in CMS 6.
- [ ] [DEPRECATED] IPUtils has been deprecated and its usage has been replaced with the IPUtils class from symfony/http-foundation which is now included as a composer dependency in silverstripe/framework.
- [ ] [DEPRECATED] Code in silverstripe/blog which supported integration with silverstripe/widgets has been deprecated and will be removed in CMS 6.0.
- [ ] [DEPRECATED] DataExtension, SiteTreeExtension, and LeftAndMainExtension have been deprecated and will be removed in CMS 6.0. If you subclass any of these classes, you should now subclass Extension directly instead.
