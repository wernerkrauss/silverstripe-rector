<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe51\Fixture;

use SilverStripe\ORM\DataList;

class OrderByRandToShuffle
{
    public function bar(DataList $list)
    {
        $random = $list->orderBy('RAND()');
        $ordered = $list->orderBy('Title DESC');
        return [$random, $ordered];
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe51\Fixture;

use SilverStripe\ORM\DataList;

class OrderByRandToShuffle
{
    public function bar(DataList $list)
    {
        $random = $list->shuffle();
        $ordered = $list->orderBy('Title DESC');
        return [$random, $ordered];
    }
}
?>
