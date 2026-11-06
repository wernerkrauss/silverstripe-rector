<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\SortRawSqlToOrderByRector\Fixture;

use SilverStripe\ORM\DataList;

class SkipTwoArgs
{
    public function bar(DataList $list)
    {
        return $list->sort('Title', 'DESC');
    }
}

?>
