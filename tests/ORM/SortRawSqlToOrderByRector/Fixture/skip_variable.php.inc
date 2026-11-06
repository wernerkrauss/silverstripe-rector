<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\SortRawSqlToOrderByRector\Fixture;

use SilverStripe\ORM\DataList;

class SkipVariable
{
    public function bar(DataList $list, $sort)
    {
        return $list->sort($sort);
    }
}

?>
