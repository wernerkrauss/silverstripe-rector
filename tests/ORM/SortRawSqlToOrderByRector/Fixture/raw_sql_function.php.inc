<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\SortRawSqlToOrderByRector\Fixture;

use SilverStripe\ORM\DataList;

class RawSqlFunction
{
    public function bar(DataList $list)
    {
        return $list->sort("FIELD(Status, 'Draft', 'Published')");
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\SortRawSqlToOrderByRector\Fixture;

use SilverStripe\ORM\DataList;

class RawSqlFunction
{
    public function bar(DataList $list)
    {
        return $list->orderBy("FIELD(Status, 'Draft', 'Published')");
    }
}

?>
