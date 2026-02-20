<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Control\ReplaceHasCurrWithCurrRector;
use Netwerkstatt\SilverstripeRector\Rector\DataObject\DataObjectGetByIdToByIDRector;
use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameClassAndConstFetch;
use Rector\Renaming\ValueObject\RenameProperty;
use Rector\Renaming\ValueObject\RenameStaticMethod;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(RenameClassRector::class, [
        'SilverStripe\ORM\ArrayLib' => 'SilverStripe\Core\ArrayLib',
        'SilverStripe\ORM\ArrayList' => 'SilverStripe\Model\List\ArrayList',
        'SilverStripe\ORM\GroupedList' => 'SilverStripe\Model\List\GroupedList',
        'SilverStripe\ORM\ListDecorator' => 'SilverStripe\Model\List\ListDecorator',
        'SilverStripe\ORM\Map' => 'SilverStripe\Model\List\Map',
        'SilverStripe\ORM\PaginatedList' => 'SilverStripe\Model\List\PaginatedList',
        'SilverStripe\ORM\SS_List' => 'SilverStripe\Model\List\SS_List',
        'SilverStripe\ORM\ValidationException' => 'SilverStripe\Core\Validation\ValidationException',
        'SilverStripe\ORM\ValidationResult' => 'SilverStripe\Core\Validation\ValidationResult',
        'SilverStripe\View\ArrayData' => 'SilverStripe\Model\ArrayData',
        'SilverStripe\View\ViewableData' => 'SilverStripe\Model\ModelData',
        'SilverStripe\View\ViewableData_Customised' => 'SilverStripe\Model\ModelDataCustomised',
        'SilverStripe\View\ViewableData_Debugger' => 'SilverStripe\Model\ModelDataDebugger',
        'SilverStripe\Logging\HTTPOutputHandler' => 'SilverStripe\Logging\ErrorOutputHandler',
        'SilverStripe\GraphQL\Extensions\DevBuildExtension' => 'SilverStripe\GraphQL\Extensions\DbBuildExtension',
        'SilverStripe\Security\PasswordValidator' => 'SilverStripe\Security\Validation\RulesPasswordValidator',
        'SilverStripe\View\SSViewer_Scope' => 'SilverStripe\TemplateEngine\ScopeManager',
        'SilverStripe\View\SSViewer_DataPresenter' => 'SilverStripe\TemplateEngine\ScopeManager',
        'SilverStripe\Forms\Validator' => 'SilverStripe\Forms\Validation\Validator',
        'SilverStripe\Forms\RequiredFields' => 'SilverStripe\Forms\Validation\RequiredFieldsValidator',
        'SilverStripe\Forms\CompositeValidator' => 'SilverStripe\Forms\Validation\CompositeValidator',
        'SilverStripe\UserForms\Form\UserFormsRequiredFields' => 'SilverStripe\UserForms\Form\UserFormsRequiredFieldsValidator',
        'Symbiote\AdvancedWorkflow\Forms\AWRequiredFields' => 'Symbiote\AdvancedWorkflow\Forms\AWRequiredFieldsValidator',
        'SilverStripe\CMS\Model\CurrentPageIdentifier' => 'SilverStripe\CMS\Model\CurrentRecordIdentifier',
        'DNADesign\Elemental\TopPage\DataExtension' => 'DNADesign\Elemental\Extensions\TopPageElementExtension',
        'DNADesign\Elemental\TopPage\FluentExtension' => 'DNADesign\Elemental\Extensions\TopPageFluentElementExtension',
        'DNADesign\Elemental\TopPage\SiteTreeExtension' => 'DNADesign\Elemental\Extensions\TopPageSiteTreeExtension',
        'SilverStripe\View\SSViewer_BasicIteratorSupport' => 'SilverStripe\TemplateEngine\BasicIteratorSupport',
        'SilverStripe\View\SSTemplateParseException' => 'SilverStripe\TemplateEngine\Exception\SSTemplateParseException',
        'SilverStripe\View\SSTemplateParser' => 'SilverStripe\TemplateEngine\SSTemplateParser',
        'SilverStripe\View\TemplateIteratorProvider' => 'SilverStripe\TemplateEngine\TemplateIteratorProvider',
        'SilverStripe\View\TemplateParser' => 'SilverStripe\TemplateEngine\TemplateParser',
        'SilverStripe\AssetAdmin\Extensions\CampaignAdminExtension' => 'SilverStripe\CampaignAdmin\Extensions\FileFormFactoryExtension',
        'SilverStripe\CMS\Controllers\LeftAndMainPageIconsExtension' => 'SilverStripe\CMS\Controllers\LeftAndMainRecordIconsExtension',
        'SilverStripe\Forms\HTMLEditor\TinyMCECombinedGenerator' => 'SilverStripe\TinyMCE\TinyMCECombinedGenerator',
        'SilverStripe\Forms\HTMLEditor\TinyMCEConfig' => 'SilverStripe\TinyMCE\TinyMCEConfig',
        'SilverStripe\Forms\HTMLEditor\TinyMCEScriptGenerator' => 'SilverStripe\TinyMCE\TinyMCEScriptGenerator',
        'SilverStripe\Dev\Constraint\ViewableDataContains' => 'SilverStripe\Dev\Constraint\ModelDataContains',
        'SilverStripe\Dev\Validation\DatabaseAdminExtension' => 'SilverStripe\Dev\Validation\DbBuildExtension',

        'SilverStripe\ORM\Filterable' => 'SilverStripe\Model\List\Filterable',
        'SilverStripe\ORM\Limitable' => 'SilverStripe\Model\List\Limitable',
        'SilverStripe\ORM\Sortable' => 'SilverStripe\Model\List\Sortable',

        'SilverStripe\SecurityReport\Forms\GridFieldExportReportButton' => 'SilverStripe\Reports\SecurityReport\Forms\GridFieldExportReportButton',
        'SilverStripe\SecurityReport\Forms\GridFieldPrintReportButton' => 'SilverStripe\Reports\SecurityReport\Forms\GridFieldPrintReportButton',
        'SilverStripe\SecurityReport\MemberReportExtension' => 'SilverStripe\Reports\SecurityReport\MemberReportExtension',
        'SilverStripe\SecurityReport\UserSecurityReport' => 'SilverStripe\Reports\SecurityReport\UserSecurityReport',
        'SilverStripe\SiteWideContentReport\Form\GridFieldBasicContentReport' => 'SilverStripe\Reports\SiteWideContentReport\Form\GridFieldBasicContentReport',
        'SilverStripe\SiteWideContentReport\Model\SitewideContentTaxonomy' => 'SilverStripe\Reports\SiteWideContentReport\Model\SitewideContentTaxonomy',
        'SilverStripe\SiteWideContentReport\SitewideContentReport' => 'SilverStripe\Reports\SiteWideContentReport\SitewideContentReport',
        'SilverStripe\ExternalLinks\Controllers\CMSExternalLinksController' => 'SilverStripe\Reports\ExternalLinks\Controllers\CMSExternalLinksController',
        'SilverStripe\ExternalLinks\Jobs\CheckExternalLinksJob' => 'SilverStripe\Reports\ExternalLinks\Jobs\CheckExternalLinksJob',
        'SilverStripe\ExternalLinks\Model\BrokenExternalLink' => 'SilverStripe\Reports\ExternalLinks\Model\BrokenExternalLink',
        'SilverStripe\ExternalLinks\Model\BrokenExternalPageTrack' => 'SilverStripe\Reports\ExternalLinks\Model\BrokenExternalPageTrack',
        'SilverStripe\ExternalLinks\Model\BrokenExternalPageTrackStatus' => 'SilverStripe\Reports\ExternalLinks\Model\BrokenExternalPageTrackStatus',
        'SilverStripe\ExternalLinks\BrokenExternalLinksReport' => 'SilverStripe\Reports\ExternalLinks\Reports\BrokenExternalLinksReport',
        'SilverStripe\ExternalLinks\Tasks\CheckExternalLinksTask' => 'SilverStripe\Reports\ExternalLinks\Tasks\CheckExternalLinksTask',
        'SilverStripe\ExternalLinks\Tasks\CurlLinkChecker' => 'SilverStripe\Reports\ExternalLinks\Tasks\CurlLinkChecker',
        'SilverStripe\ExternalLinks\Tasks\LinkChecker' => 'SilverStripe\Reports\ExternalLinks\Tasks\LinkChecker',


        //removed extensions
        'SilverStripe\ORM\DataExtension' => 'SilverStripe\Core\Extension',
        'SilverStripe\CMS\Model\SiteTreeExtension' => 'SilverStripe\Core\Extension',
        'SilverStripe\Admin\LeftAndMainExtension' => 'SilverStripe\Core\Extension',

    ]);
    $rectorConfig->importNames();
    $rectorConfig->removeUnusedImports();
    $rectorConfig->ruleWithConfiguration(RenameStaticMethodRector::class, [
        new RenameStaticMethod('SilverStripe\View\SSViewer', 'flush', 'SilverStripe\TemplateEngine\SSTemplateEngine',
            'flush'),
        new RenameStaticMethod('SilverStripe\ORM\FieldType\DBEnum', 'flushCache', 'SilverStripe\ORM\FieldType\DBEnum',
            'reset'),
    ]);
    $rectorConfig->ruleWithConfiguration(RenamePropertyRector::class, [
        new RenameProperty('SilverStripe\Admin\LeftAndMain', 'tree_class', 'model_class'),
        new RenameProperty('SilverStripe\CMS\Model\SiteTree', 'description', 'class_description'),
        new RenameProperty('SilverStripe\CMS\Model\SiteTree', 'icon', 'cms_icon'),
        new RenameProperty('SilverStripe\CMS\Model\SiteTree', 'icon_class', 'cms_icon_class'),
        new RenameProperty('DNADesign\Elemental\Models\BaseElement', 'description', 'class_description'),
    ]);
    $rectorConfig->ruleWithConfiguration(RenameMethodRector::class, [
        new MethodCallRename('SilverStripe\TemplateEngine\ScopeManager', 'obj', 'scopeToIntermediateValue'),
        new MethodCallRename('SilverStripe\ORM\CMSPreviewable', 'CMSEditLink', 'getCMSEditLink'),
        new MethodCallRename('SilverStripe\CMS\Model\CurrentRecordIdentifier', 'currentPageID', 'currentRecordID'),
        new MethodCallRename('SilverStripe\CMS\Model\CurrentRecordIdentifier', 'isCurrentPage', 'isCurrentRecord'),
        new MethodCallRename('SilverStripe\Assets\Storage\DBFile', 'validate', 'validateFilename'),
        new MethodCallRename('SilverStripe\CMS\Controllers\ContentController', 'Menu', 'getMenu'),
        new MethodCallRename('SilverStripe\Model\ModelData', 'cachedCall', 'obj'),
        new MethodCallRename('SilverStripe\SiteConfig\SiteConfigLeftAndMain', 'save_siteconfig', 'save'),
        new MethodCallRename('SilverStripe\Admin\LeftAndMain', 'currentPageID', 'currentRecordID'),
        new MethodCallRename('SilverStripe\Admin\LeftAndMain', 'setCurrentPageID', 'setCurrentRecordID'),
        new MethodCallRename('SilverStripe\Admin\LeftAndMain', 'currentPage', 'currentRecord'),
        new MethodCallRename('SilverStripe\Admin\LeftAndMain', 'isCurrentPage', 'isCurrentRecord'),
        new MethodCallRename('SilverStripe\CMS\Controllers\CMSMain', 'PageList', 'RecordList'),
        new MethodCallRename('SilverStripe\CMS\Controllers\CMSMain', 'LinkPages', 'LinkRecords'),
        new MethodCallRename('SilverStripe\CMS\Controllers\CMSMain', 'LinkPagesWithSearch', 'LinkRecordsWithSearch'),
        new MethodCallRename('SilverStripe\CMS\Controllers\CMSMain', 'LinkPageEdit', 'LinkRecordEdit'),
        new MethodCallRename('SilverStripe\CMS\Controllers\CMSMain', 'LinkPageSettings', 'LinkRecordSettings'),
        new MethodCallRename('SilverStripe\CMS\Controllers\CMSMain', 'LinkPageHistory', 'LinkRecordHistory'),
        new MethodCallRename('SilverStripe\CMS\Controllers\CMSMain', 'LinkPageAdd', 'LinkRecordAdd'),
        new MethodCallRename('SilverStripe\CMS\Controllers\CMSMain', 'SiteTreeAsUL', 'TreeAsUL'),
        new MethodCallRename('SilverStripe\CMS\Controllers\CMSMain', 'getSiteTreeFor', 'getTreeFor'),
        new MethodCallRename('SilverStripe\CMS\Controllers\CMSMain', 'CanOrganiseSitetree', 'canOrganiseTree'),
        new MethodCallRename('SilverStripe\CMS\Controllers\CMSMain', 'getPageTypes', 'getRecordTypes'),
        new MethodCallRename('SilverStripe\CMS\Controllers\CMSMain', 'PageTypes', 'RecordTypes'),
        new MethodCallRename('SilverStripe\CMS\Controllers\CMSMain', 'SiteTreeHints', 'TreeHints'),
        new MethodCallRename('SilverStripe\CMS\Controllers\LeftAndMainRecordIconsExtension', 'generatePageIconsCss',
            'generateRecordIconsCss'),
        new MethodCallRename('SilverStripe\Forms\Form', 'validationResult', 'validate'),
        new MethodCallRename('SilverStripe\Forms\TextareaField', 'ValueEntities', 'getFormattedValueEntities'),
        new MethodCallRename('SilverStripe\Model\List\ListDecorator', 'TotalItems', 'getTotalItems'),
        new MethodCallRename('SilverStripe\Model\List\PaginatedList', 'TotalItems', 'getTotalItems'),

        // Member hooks
        new MethodCallRename('SilverStripe\Core\Extension', 'afterMemberLoggedIn', 'onAfterMemberLoggedIn'),
        new MethodCallRename('SilverStripe\Core\Extension', 'afterMemberLoggedOut', 'onAfterMemberLoggedOut'),
        new MethodCallRename('SilverStripe\Core\Extension', 'authenticationFailed', 'onAuthenticationFailed'),
        new MethodCallRename('SilverStripe\Core\Extension', 'authenticationFailedUnknownUser',
            'onAuthenticationFailedUnknownUser'),
        new MethodCallRename('SilverStripe\Core\Extension', 'authenticationSucceeded', 'onAuthenticationSucceeded'),
        new MethodCallRename('SilverStripe\Core\Extension', 'beforeMemberLoggedIn', 'onBeforeMemberLoggedIn'),
        new MethodCallRename('SilverStripe\Core\Extension', 'beforeMemberLoggedOut', 'onBeforeMemberLoggedOut'),
        new MethodCallRename('SilverStripe\Core\Extension', 'registerFailedLogin', 'onRegisterFailedLogin'),
        // LeftAndMain hooks
        new MethodCallRename('SilverStripe\Core\Extension', 'init', 'onInit'),
        // DataObject hooks
        new MethodCallRename('SilverStripe\Core\Extension', 'flushCache', 'onFlushCache'),
        new MethodCallRename('SilverStripe\Core\Extension', 'populateDefaults', 'onAfterPopulateDefaults'),
        new MethodCallRename('SilverStripe\Core\Extension', 'requireDefaultRecords', 'onRequireDefaultRecords'),
        // LostPasswordHandler hooks
        new MethodCallRename('SilverStripe\Core\Extension', 'forgotPassword', 'onForgotPassword'),
        // ErrorPage hooks
        new MethodCallRename('SilverStripe\Core\Extension', 'getDefaultRecords', 'updateDefaultRecords'),
        // SiteTree hooks
        new MethodCallRename('SilverStripe\Core\Extension', 'MetaComponents', 'updateMetaComponents'),
        new MethodCallRename('SilverStripe\Core\Extension', 'MetaTags', 'updateMetaTags'),
        // DataObject validation hook
        new MethodCallRename('SilverStripe\Core\Extension', 'validate', 'updateValidate'),
    ]);
    $rectorConfig->rule(ReplaceHasCurrWithCurrRector::class);
    $rectorConfig->rule(DataObjectGetByIdToByIDRector::class);
    $rectorConfig->ruleWithConfiguration(RenameClassConstFetchRector::class, [
        new RenameClassAndConstFetch('SilverStripe\Admin\LeftAndMain', 'SCHEMA_HEADER',
            'SilverStripe\Forms\Schema\FormSchema', 'SCHEMA_HEADER'),
    ]);
};
