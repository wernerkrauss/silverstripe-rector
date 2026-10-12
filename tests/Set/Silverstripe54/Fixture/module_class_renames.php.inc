<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use DNADesign\Elemental\TopPage\DataExtension;
use DNADesign\Elemental\TopPage\FluentExtension;
use DNADesign\Elemental\TopPage\SiteTreeExtension;
use SilverStripe\AssetAdmin\Extensions\CampaignAdminExtension;
use SilverStripe\Dev\Constraint\ViewableDataContains;
use SilverStripe\Dev\Validation\DatabaseAdminExtension;
use SilverStripe\Forms\CompositeValidator;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\Validator;
use SilverStripe\GraphQL\Extensions\DevBuildExtension;
use SilverStripe\Security\PasswordValidator;

final class ModuleClassRenames
{
    public function test(): void
    {
        $validator = new Validator();
        $required = new RequiredFields();
        $composite = new CompositeValidator();
        $password = new PasswordValidator();
        $build = new DevBuildExtension();
        $campaign = new CampaignAdminExtension();
        $constraint = new ViewableDataContains();
        $database = new DatabaseAdminExtension();
        $elemental = new DataExtension();
        $fluent = new FluentExtension();
        $siteTree = new SiteTreeExtension();
    }
}
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\Validation\Validator;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;
use SilverStripe\Forms\Validation\CompositeValidator;
use SilverStripe\Security\Validation\RulesPasswordValidator;
use SilverStripe\GraphQL\Extensions\DbBuildExtension;
use SilverStripe\CampaignAdmin\Extensions\FileFormFactoryExtension;
use SilverStripe\Dev\Constraint\ModelDataContains;
use DNADesign\Elemental\Extensions\TopPageElementExtension;
use DNADesign\Elemental\Extensions\TopPageFluentElementExtension;
use DNADesign\Elemental\Extensions\TopPageSiteTreeExtension;


final class ModuleClassRenames
{
    public function test(): void
    {
        $validator = new Validator();
        $required = new RequiredFieldsValidator();
        $composite = new CompositeValidator();
        $password = new RulesPasswordValidator();
        $build = new DbBuildExtension();
        $campaign = new FileFormFactoryExtension();
        $constraint = new ModelDataContains();
        $database = new \SilverStripe\Dev\Validation\DbBuildExtension();
        $elemental = new TopPageElementExtension();
        $fluent = new TopPageFluentElementExtension();
        $siteTree = new TopPageSiteTreeExtension();
    }
}
