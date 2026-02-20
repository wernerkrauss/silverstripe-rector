<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\ORM\ArrayList;

class ArrayListRename
{
    public function run()
    {
        $list = new ArrayList();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\Model\List\ArrayList;

class ArrayListRename
{
    public function run()
    {
        $list = new ArrayList();
    }
}
?>
