<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\View\ViewableData;

class ViewableDataRename
{
    public function run()
    {
        $data = new ViewableData();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\Model\ModelData;

class ViewableDataRename
{
    public function run()
    {
        $data = new ModelData();
    }
}
?>
