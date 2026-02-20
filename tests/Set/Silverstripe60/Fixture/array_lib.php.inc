<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\ORM\ArrayLib;

class ArrayLibRename
{
    public function run()
    {
        $lib = ArrayLib::class;
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\Core\ArrayLib;

class ArrayLibRename
{
    public function run()
    {
        $lib = ArrayLib::class;
    }
}
?>
