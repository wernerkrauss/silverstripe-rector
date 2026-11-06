<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\SortRawSqlToOrderByRector\Fixture;

use SilverStripe\ORM\DataList;

class SkipArray
{
    public function bar(DataList $list)
    {
        return $list->sort(['Title' => 'ASC', 'Created' => 'DESC']);
    }
}

?>
