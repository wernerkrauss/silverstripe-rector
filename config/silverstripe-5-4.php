<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\SilverstripeDeprecationCommentRector;
use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameStaticMethod;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(RenameClassRector::class, [
        'SilverStripe\\ORM\\ArrayLib' => 'SilverStripe\\Core\\ArrayLib',
        'SilverStripe\\ORM\\ArrayList' => 'SilverStripe\\Model\\List\\ArrayList',
        'SilverStripe\\ORM\\GroupedList' => 'SilverStripe\\Model\\List\\GroupedList',
        'SilverStripe\\ORM\\ListDecorator' => 'SilverStripe\\Model\\List\\ListDecorator',
        'SilverStripe\\ORM\\Map' => 'SilverStripe\\Model\\List\\Map',
        'SilverStripe\\ORM\\PaginatedList' => 'SilverStripe\\Model\\List\\PaginatedList',
        'SilverStripe\\ORM\\SS_List' => 'SilverStripe\\Model\\List\\SS_List',
        'SilverStripe\\ORM\\ValidationException' => 'SilverStripe\\Core\\Validation\\ValidationException',
        'SilverStripe\\ORM\\ValidationResult' => 'SilverStripe\\Core\\Validation\\ValidationResult',
        'SilverStripe\\View\\ArrayData' => 'SilverStripe\\Model\\ArrayData',
        'SilverStripe\\View\\ViewableData' => 'SilverStripe\\Model\\ModelData',
        'SilverStripe\\View\\ViewableData_Customised' => 'SilverStripe\\Model\\ModelDataCustomised',
        'SilverStripe\\View\\ViewableData_Debugger' => 'SilverStripe\\Model\\ModelDataDebugger',
        'SilverStripe\\Logging\\HTTPOutputHandler' => 'SilverStripe\\Logging\\ErrorOutputHandler',
        'SilverStripe\\ORM\\Filterable' => 'SilverStripe\\Model\\List\\Filterable',
        'SilverStripe\\ORM\\Limitable' => 'SilverStripe\\Model\\List\\Limitable',
        'SilverStripe\\ORM\\Sortable' => 'SilverStripe\\Model\\List\\Sortable',
        'SilverStripe\\GraphQL\\Extensions\\DevBuildExtension' => 'SilverStripe\\GraphQL\\Extensions\\DbBuildExtension',
        'SilverStripe\\Security\\PasswordValidator' => 'SilverStripe\\Security\\Validation\\RulesPasswordValidator',
        'SilverStripe\\Forms\\Validator' => 'SilverStripe\\Forms\\Validation\\Validator',
        'SilverStripe\\Forms\\RequiredFields' => 'SilverStripe\\Forms\\Validation\\RequiredFieldsValidator',
        'SilverStripe\\Forms\\CompositeValidator' => 'SilverStripe\\Forms\\Validation\\CompositeValidator',
        'SilverStripe\\UserForms\\Form\\UserFormsRequiredFields' => 'SilverStripe\\UserForms\\Form\\UserFormsRequiredFieldsValidator',
        'Symbiote\\AdvancedWorkflow\\Forms\\AWRequiredFields' => 'Symbiote\\AdvancedWorkflow\\Forms\\AWRequiredFieldsValidator',
        'SilverStripe\\AssetAdmin\\Extensions\\CampaignAdminExtension' => 'SilverStripe\\CampaignAdmin\\Extensions\\FileFormFactoryExtension',
        'SilverStripe\\Forms\\HTMLEditor\\TinyMCECombinedGenerator' => 'SilverStripe\\TinyMCE\\TinyMCECombinedGenerator',
        'SilverStripe\\Forms\\HTMLEditor\\TinyMCEConfig' => 'SilverStripe\\TinyMCE\\TinyMCEConfig',
        'SilverStripe\\Forms\\HTMLEditor\\TinyMCEScriptGenerator' => 'SilverStripe\\TinyMCE\\TinyMCEScriptGenerator',
        'SilverStripe\\Dev\\Constraint\\ViewableDataContains' => 'SilverStripe\\Dev\\Constraint\\ModelDataContains',
        'SilverStripe\\Dev\\Validation\\DatabaseAdminExtension' => 'SilverStripe\\Dev\\Validation\\DbBuildExtension',
        'DNADesign\\Elemental\\TopPage\\DataExtension' => 'DNADesign\\Elemental\\Extensions\\TopPageElementExtension',
        'DNADesign\\Elemental\\TopPage\\FluentExtension' => 'DNADesign\\Elemental\\Extensions\\TopPageFluentElementExtension',
        'DNADesign\\Elemental\\TopPage\\SiteTreeExtension' => 'DNADesign\\Elemental\\Extensions\\TopPageSiteTreeExtension',
        'SilverStripe\\View\\SSViewer_Scope' => 'SilverStripe\\TemplateEngine\\ScopeManager',
        'SilverStripe\\View\\SSViewer_DataPresenter' => 'SilverStripe\\TemplateEngine\\ScopeManager',
        'SilverStripe\\View\\SSViewer_BasicIteratorSupport' => 'SilverStripe\\TemplateEngine\\BasicIteratorSupport',
        'SilverStripe\\View\\SSTemplateParseException' => 'SilverStripe\\TemplateEngine\\Exception\\SSTemplateParseException',
        'SilverStripe\\View\\SSTemplateParser' => 'SilverStripe\\TemplateEngine\\SSTemplateParser',
        'SilverStripe\\View\\TemplateIteratorProvider' => 'SilverStripe\\TemplateEngine\\TemplateIteratorProvider',
        'SilverStripe\\View\\TemplateParser' => 'SilverStripe\\TemplateEngine\\TemplateParser',
        'SilverStripe\\CMS\\Model\\CurrentPageIdentifier' => 'SilverStripe\\CMS\\Model\\CurrentRecordIdentifier',
        'SilverStripe\\CMS\\Controllers\\LeftAndMainPageIconsExtension' => 'SilverStripe\\CMS\\Controllers\\LeftAndMainRecordIconsExtension',
    ]);

    $rectorConfig->ruleWithConfiguration(RenameMethodRector::class, [
        new MethodCallRename('SilverStripe\ORM\ListDecorator', 'TotalItems', 'getTotalItems'),
        new MethodCallRename('SilverStripe\ORM\PaginatedList', 'TotalItems', 'getTotalItems'),
    ]);

    $rectorConfig->ruleWithConfiguration(RenameStaticMethodRector::class, [
        new RenameStaticMethod('SilverStripe\\View\\SSViewer', 'flush', 'SilverStripe\\TemplateEngine\\SSTemplateEngine', 'flush'),
        new RenameStaticMethod('SilverStripe\\View\\SSViewer', 'fromString', 'SilverStripe\\TemplateEngine\\SSTemplateEngine', 'renderString'),
        new RenameStaticMethod('SilverStripe\\View\\SSViewer', 'setTemplate', 'SilverStripe\\TemplateEngine\\SSTemplateEngine', 'setTemplate'),
        new RenameStaticMethod('SilverStripe\\View\\SSViewer', 'setParser', 'SilverStripe\\TemplateEngine\\SSTemplateEngine', 'setParser'),
        new RenameStaticMethod('SilverStripe\\View\\SSViewer', 'getParser', 'SilverStripe\\TemplateEngine\\SSTemplateEngine', 'getParser'),
        new RenameStaticMethod('SilverStripe\\View\\SSViewer', 'hasTemplate', 'SilverStripe\\TemplateEngine\\SSTemplateEngine', 'hasTemplate'),
        new RenameStaticMethod('SilverStripe\\View\\SSViewer', 'flush_template_cache', 'SilverStripe\\TemplateEngine\\SSTemplateEngine', 'flushTemplateCache'),
        new RenameStaticMethod('SilverStripe\\View\\SSViewer', 'flush_cacheblock_cache', 'SilverStripe\\TemplateEngine\\SSTemplateEngine', 'flushCacheBlockCache'),
        new RenameStaticMethod('SilverStripe\\View\\SSViewer', 'setPartialCacheStore', 'SilverStripe\\TemplateEngine\\SSTemplateEngine', 'setPartialCacheStore'),
        new RenameStaticMethod('SilverStripe\\View\\SSViewer', 'getPartialCacheStore', 'SilverStripe\\TemplateEngine\\SSTemplateEngine', 'getPartialCacheStore'),
        new RenameStaticMethod('SilverStripe\\View\\SSViewer', 'includeGeneratedTemplate', 'SilverStripe\\TemplateEngine\\SSTemplateEngine', 'includeGeneratedTemplate'),
        new RenameStaticMethod('SilverStripe\\View\\SSViewer', 'getSubtemplateFor', 'SilverStripe\\TemplateEngine\\SSTemplateEngine', 'getSubtemplateFor'),
        new RenameStaticMethod('SilverStripe\\View\\SSViewer', 'parseTemplateContent', 'SilverStripe\\TemplateEngine\\SSTemplateEngine', 'parseTemplateContent'),
        new RenameStaticMethod('SilverStripe\\ORM\\FieldType\\DBEnum', 'flushCache', 'SilverStripe\\ORM\\FieldType\\DBEnum', 'reset'),
    ]);

    $rectorConfig->ruleWithConfiguration(RenameClassRector::class, [
    ]);

    $rectorConfig->ruleWithConfiguration(SilverstripeDeprecationCommentRector::class, [
        'SilverStripe\Control\Director::alternate_public_dir' => [
            'message' => 'The Director.alternate_public_dir configuration property has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Dev\DevelopmentAdmin' => [
            'message' => 'DevelopmentAdmin has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Dev\DevelopmentAdmin::getRegisteredController' => [
            'message' => 'DevelopmentAdmin::getRegisteredController() has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\View\ViewableData::castingClass' => [
            'message' => 'ViewableData::castingClass() has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Model\ModelData::castingClass' => [
            'message' => 'ViewableData::castingClass() has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\View\ViewableData::escapeTypeForField' => [
            'message' => 'ViewableData::escapeTypeForField() has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Model\ModelData::escapeTypeForField' => [
            'message' => 'ViewableData::escapeTypeForField() has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Forms\TextareaField::ValueEntities' => [
            'message' => 'TextareaField::ValueEntities() has been deprecated. Use getFormattedValueEntities() instead.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Forms\GridField\GridFieldDataColumns::getValueFromRelation' => [
            'message' => 'GridFieldDataColumns::getValueFromRelation() has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Forms\FormField::Value' => [
            'message' => 'FormField::Value() has been deprecated. It will be replaced by getFormattedValue() and getValue().',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Control\Director::get_session_environment_type' => [
            'message' => 'Director::get_session_environment_type() has been deprecated. Use Director::get_environment_type() instead.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
    ]);
    $rectorConfig->importNames();
    $rectorConfig->removeUnusedImports();
};
