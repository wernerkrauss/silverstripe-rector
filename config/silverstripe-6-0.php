<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\Name\RenameClassRector;

return static function (RectorConfig $rectorConfig): void {

    $rectorConfig->ruleWithConfiguration(RenameClassRector::class, [
        'SilverStripe\ORM\ArrayLib' => 'SilverStripe\Core\ArrayLib',
        'SilverStripe\ORM\ArrayList' => 'SilverStripe\Model\List\ArrayList',
        'SilverStripe\ORM\Filterable' => 'SilverStripe\Model\List\Filterable',
        'SilverStripe\ORM\GroupedList' => 'SilverStripe\Model\List\GroupedList',
        'SilverStripe\ORM\Limitable' => 'SilverStripe\Model\List\Limitable',
        'SilverStripe\ORM\ListDecorator' => 'SilverStripe\Model\List\ListDecorator',
        'SilverStripe\ORM\Map' => 'SilverStripe\Model\List\Map',
        'SilverStripe\ORM\PaginatedList' => 'SilverStripe\Model\List\PaginatedList',
        'SilverStripe\ORM\Sortable' => 'SilverStripe\Model\List\Sortable',
        'SilverStripe\ORM\SS_List' => 'SilverStripe\Model\List\SS_List',
        'SilverStripe\ORM\ValidationException' => 'SilverStripe\Core\Validation\ValidationException',
        'SilverStripe\ORM\ValidationResult' => 'SilverStripe\Core\Validation\ValidationResult',
        'SilverStripe\View\ArrayData' => 'SilverStripe\Model\ArrayData',
        'SilverStripe\View\ViewableData' => 'SilverStripe\Model\ModelData',
        'SilverStripe\View\ViewableData_Customised' => 'SilverStripe\Model\ModelDataCustomised',
        'SilverStripe\View\ViewableData_Debugger' => 'SilverStripe\Model\ModelDataDebugger',

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

        'SilverStripe\Forms\Validator' => 'SilverStripe\Forms\Validation\Validator',
        'SilverStripe\Forms\RequiredFields' => 'SilverStripe\Forms\Validation\RequiredFieldsValidator',
        'SilverStripe\Forms\CompositeValidator' => 'SilverStripe\Forms\Validation\CompositeValidator',
        'SilverStripe\UserForms\Form\UserFormsRequiredFields' => 'SilverStripe\UserForms\Form\UserFormsRequiredFieldsValidator',
        'Symbiote\AdvancedWorkflow\Forms\AWRequiredFields' => 'Symbiote\AdvancedWorkflow\Forms\AWRequiredFieldsValidator',

        //removed extensions
        'SilverStripe\ORM\DataExtension' => 'SilverStripe\Core\Extension',
        'SilverStripe\CMS\Model\SiteTreeExtension' => 'SilverStripe\Core\Extension',
        'SilverStripe\Admin\LeftAndMainExtension' => 'SilverStripe\Core\Extension',

    ]);
};