<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\OrderByRandToShuffleRector\Fixture;

use SilverStripe\ORM\DataList;

class SkipRegularOrderBy
{
    public function bar(DataList $list)
    {
        return $list->orderBy('Title DESC');
    }
}

?>
