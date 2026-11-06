<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\SortRawSqlToOrderByRector\Fixture;

class SkipOtherList
{
    public function sort($column)
    {
        return $column;
    }
}

class SkipOtherClass
{
    public function bar(SkipOtherList $list)
    {
        return $list->sort("FIELD(Status, 'Draft', 'Published')");
    }
}

?>
