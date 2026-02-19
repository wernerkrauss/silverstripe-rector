# Silverstripe 6.1.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/6/changelogs/6.1.0/#api-changes)

- [ ] [DEPRECATED] The Session.session_store_path configuration property has been deprecated. Use session.save_path in ini configuration instead.
- [ ] [DEPRECATED] The Session.sessionCacheLimiter has been deprecated and will be removed without equivalent functionality to replace it in a future major release.
- [ ] [DEPRECATED] The DataObject::get_by_id() method has been deprecated. Use DataObject::get($className)->setUseCache(true)->byID($id) instead.
- [ ] [DEPRECATED] The DataObject::get_one() method has been deprecated. Use DataObject::get($className)->setUseCache(true)->first() instead.
- [ ] [DEPRECATED] The DataObject::delete_by_id() method has been deprecated. Use DataObject::get($className)->setUseCache(true)->byID($id)->delete() instead.
- [ ] [DEPRECATED] UpgradePolymorphicExtension has been deprecated and will be removed without equivalent functionality to replace it in a future major release.
- [ ] [DEPRECATED] The UserForm.upgrade_on_build configuration property has been deprecated and will be removed without equivalent functionality to replace it in a future major release.
