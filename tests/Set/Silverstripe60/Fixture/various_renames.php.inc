<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\View\SSViewer_Scope;
use SilverStripe\View\SSViewer_DataPresenter;
use SilverStripe\ORM\ValidationException;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Logging\HTTPOutputHandler;
use SilverStripe\Security\PasswordValidator;
use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;


class VariousRenames
{
    public function run()
    {
        $scope = new SSViewer_Scope();
        $presenter = new SSViewer_DataPresenter();
        $exception = new ValidationException();
        $result = new ValidationResult();
        $handler = new HTTPOutputHandler();
        $validator = new PasswordValidator();
        $obj = DataObject::get_by_id(SiteTree::class, 123);
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\TemplateEngine\ScopeManager;
use SilverStripe\Core\Validation\ValidationException;
use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Logging\ErrorOutputHandler;
use SilverStripe\Security\Validation\RulesPasswordValidator;
use SilverStripe\CMS\Model\SiteTree;


class VariousRenames
{
    public function run()
    {
        $scope = new ScopeManager();
        $presenter = new ScopeManager();
        $exception = new ValidationException();
        $result = new ValidationResult();
        $handler = new ErrorOutputHandler();
        $validator = new RulesPasswordValidator();
        $obj = SiteTree::get()->byID(123);
    }
}
?>
