<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\View\SSViewer;
use SilverStripe\View\SSViewer_Scope;

class TemplateMethodRenamesTest
{
    public function test(SSViewer_Scope $scope): void
    {
        $item = $scope->getItem();
        $baseTag = SSViewer::get_base_tag();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\TemplateEngine\ScopeManager;
use SilverStripe\View\SSViewer;

class TemplateMethodRenamesTest
{
    public function test(ScopeManager $scope): void
    {
        $item = $scope->getCurrentItem();
        $baseTag = SSViewer::getBaseTag();
    }
}
?>
