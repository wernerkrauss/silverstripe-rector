# Silverstripe 6.0.0 Rector TODOs

Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/6/changelogs/6.0.0/#api-changes)

- [ ] Added a new ViewLayerData class which sits between the template layer and the model layer. All data that gets used in the template layer gets wrapped in a ViewLayerData instance first. This class provides a consistent API and value lookup logic so that all data gets treated the same way once it's in the template layer.
- [ ] Move casting logic into a new CastingService class. This class is responsible for casting data to the correct model (e.g. by default strings get cast to DBText and booleans get cast to DBBoolean). If the source of the data is known and is an instance of ModelData, the casting service calls ModelData::castingHelper() to ensure the ModelData.casting configuration and (in the case of DataObject) the db schema are taken into account.
- [ ] Implemented a default ModelData::forTemplate() method which will attempt to render the model using templates named after it and its superclasses. See forTemplate and $Me for information about this method's usage. ModelDataCustomised::forTemplate() explicitly uses the forTemplate() method of the class being customised, not from the class providing the customisation.
- [ ] [REMOVED] The ModelData::XML_val() method has been removed as it is no longer needed to get values for usage in templates.
- [ ] The ModelData::obj() method now also passes arguments into getter methods. Note however that this method is no longer used to get values in the template layer.
- [ ] The ModelData::objCacheSet() and ModelData::objCacheGet() methods now deal with raw values prior to being cast. This is so that ViewLayerData can use the cache reliably.
- [ ] Nothing in core or supported modules (except for the template engine itself) relies on absolute file paths for templates - instead, template names and relative paths (without the .ss extension) are used. Email::getHTMLTemplate() now returns an array of template candidates, unless a specific template was set using setHTMLTemplate().
- [ ] [REMOVED] ThemeResourceLoader::findTemplate() has been removed without a replacement.
- [ ] [REMOVED] SSViewer::chooseTemplate() has been removed without a replacement.
- [ ] TemplateEngine classes will throw a MissingTemplateException if there is no file mapping to any of the template candidates passed to them.
- [ ] The Email::setHTMLTemplate() and Email::setPlainTemplate() methods used to strip the .ss extension off strings passed into them. They no longer do this. You should double check any calls to those methods and remove the .ss extension from any strings you're passing in, unless those strings represent full absolute file paths.
- [ ] [REMOVED] The old &#x3C;% _t("My_KEY", "Default text") %> and &#x3C;% sprintf(_t("My_KEY", "Default text with %s"), "replacement") %> i18n syntaxes have been removed. Use the syntax described in the i18n documentation instead.
- [ ] Act as the barrier between the template layer and the model layer
- [ ] Actually process and render templates
- [ ] The SSViewer.global_key configuration property is now SSTemplateEngine.global_key.
- [ ] [REMOVED] SSViewer::chooseTemplate() has been removed without a replacement.
- [ ] SSViewer::hasTemplate() is now TemplateEngine::hasTemplate().
- [ ] SSViewer::fromString() and the SSViewer_FromString class have been replaced with TemplateEngine::renderString().
- [ ] [REMOVED] The SiteTree.need_permission configuration property has been removed. This wasn't used in permission checks anyway, so these permissions would have had to be separately checked in canCreate() to have the intended effect. If you were using this configuration property, implement a change to canCreate() in your Page class instead.
- [ ] [RENAME/MOVE] The SiteTree.description configuration property has been renamed to class_description. This configuration has been added to DataObject along with the corresponding classDescription() and i18n_classDescription() methods.
- [ ] The BaseElement::getTypeNice() method now calls i18n_classDescription() to get the text it will display.
- [ ] The Hierarchy extension now has a bunch of configuration and methods which used to be exclusive to SiteTree.
- [ ] FormField::getValue() which usually returns an unmodified version of the value
- [ ] FormField::getFormattedValue() which is intended to be modified with things like localisation formatting and will be displayed to users
- [ ] FormField::dataValue() which represents the value as passed into a record when saveInto() is called. Usually this is the same as getValue().
- [ ] DataObject::validate() now has an explicit ValidationResult return type.
- [ ] DataObject::write() has a new boolean $skipValidation parameter. This can be useful for scenarios where you want to automatically create a new record with no data initially without restricting how developers can set up their validation rules.
- [ ] FieldList is now strongly typed. Methods that previously allowed any iterable variables to be passed, namely FieldList::addFieldsToTab() and FieldList::removeFieldsFromTab(), now require an array to be passed instead.
- [ ] [REMOVED] DNADesign\Elemental\Models\BaseElement::getDescription() and the corresponding DNADesign\Elemental\Models\BaseElement.description configuration property have been removed. If you were using either of these in your custom elemental blocks, either set the new class_description configuration property or override one of the i18n_classDescription() or getTypeNice() methods instead.
- [ ] [REMOVED] SilverStripe\ORM\DataExtension, SilverStripe\CMS\Model\SiteTreeExtension, and SilverStripe\Admin\LeftAndMainExtension have been removed. If you subclass any of these classes, you must now subclass Extension directly instead.
- [ ] [REMOVED] The SilverStripe\Model\List\ArrayList.default_case_sensitive configuration property has been removed. This means the default case sensitivity of ArrayList is now the same as any other list which uses search filters. If you were using that configuration property, or you were relying on ArrayList being case sensitive by default, you should double check that your list filters are working the way you expect. See search filters for details about case sensitivity in search filters.
- [ ] The execution flow for ChangePasswordHandler::changepassword() has changed slightly. The session isn't updated until after the redirect now. If you overrode that method expecting the session to be updated prior to the redirect, you probably want to override the new protected createChangePasswordResponse() method instead.
- [ ] [RENAME/MOVE] The CMSEditLink() method on many DataObject subclasses has been renamed to getCMSEditLink().
- [ ] [REMOVED] Support for the $CurrentPageURL template variable, which was previously used to populate email templates with the current page URL, has been removed. This variable was unreliable and is no longer supported.
