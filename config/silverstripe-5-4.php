<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\Name\RenameClassRector;

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
        'SilverStripe\Forms\Validator' => 'SilverStripe\Forms\Validation\Validator',
        'SilverStripe\Forms\RequiredFields' => 'SilverStripe\Forms\Validation\RequiredFieldsValidator',
        'SilverStripe\Forms\CompositeValidator' => 'SilverStripe\Forms\Validation\CompositeValidator',
        'SilverStripe\UserForms\Form\UserFormsRequiredFields' => 'SilverStripe\UserForms\Form\UserFormsRequiredFieldsValidator',
        'Symbiote\AdvancedWorkflow\Forms\AWRequiredFields' => 'Symbiote\AdvancedWorkflow\Forms\AWRequiredFieldsValidator',
        'SilverStripe\CMS\Model\CurrentPageIdentifier' => 'SilverStripe\CMS\Model\CurrentRecordIdentifier.',
        'DNADesign\Elemental\TopPage\DataExtension' => 'DNADesign\Elemental\Extensions\TopPageElementExtension',
        'DNADesign\Elemental\TopPage\FluentExtension' => 'DNADesign\Elemental\Extensions\TopPageFluentElementExtension',
        'DNADesign\Elemental\TopPage\SiteTreeExtension' => 'DNADesign\Elemental\Extensions\TopPageSiteTreeExtension'
    ]);

};
