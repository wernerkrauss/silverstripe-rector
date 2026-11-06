<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\SortRawSqlToOrderByRector\Fixture;

use SilverStripe\ORM\DataList;

class SkipFieldNameAndDirection
{
    public function bar(DataList $list)
    {
        $a = $list->sort('Title');
        $b = $list->sort('Title DESC');
        return [$a, $b];
    }
}

?>
