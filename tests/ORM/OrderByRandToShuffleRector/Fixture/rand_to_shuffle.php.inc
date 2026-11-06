<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\OrderByRandToShuffleRector\Fixture;

use SilverStripe\ORM\DataList;

class RandToShuffle
{
    public function bar(DataList $list)
    {
        $a = $list->orderBy('RAND()');
        $b = $list->orderBy(' rand( ) ');
        return [$a, $b];
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\OrderByRandToShuffleRector\Fixture;

use SilverStripe\ORM\DataList;

class RandToShuffle
{
    public function bar(DataList $list)
    {
        $a = $list->shuffle();
        $b = $list->shuffle();
        return [$a, $b];
    }
}

?>
