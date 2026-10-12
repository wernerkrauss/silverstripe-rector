<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\View\ViewableData;
use SilverStripe\View\ViewableData_Customised;
use SilverStripe\View\ViewableData_Debugger;

final class ModelDataClassRenames
{
    public function test(): void
    {
        $data = new ViewableData();
        $customised = new ViewableData_Customised();
        $debugger = new ViewableData_Debugger();
    }
}
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Model\ModelData;
use SilverStripe\Model\ModelDataCustomised;
use SilverStripe\Model\ModelDataDebugger;

final class ModelDataClassRenames
{
    public function test(): void
    {
        $data = new ModelData();
        $customised = new ModelDataCustomised();
        $debugger = new ModelDataDebugger();
    }
}
