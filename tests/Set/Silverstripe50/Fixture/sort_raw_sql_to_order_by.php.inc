<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe50\Fixture;

use SilverStripe\ORM\DataList;

class SortRawSqlToOrderBy
{
    public function bar(DataList $list)
    {
        $pages = $list->sort("FIELD(Status, 'Draft', 'Published')");
        $byTitle = $list->sort('Title DESC');
        return [$pages, $byTitle];
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe50\Fixture;

use SilverStripe\ORM\DataList;

class SortRawSqlToOrderBy
{
    public function bar(DataList $list)
    {
        $pages = $list->orderBy("FIELD(Status, 'Draft', 'Published')");
        $byTitle = $list->sort('Title DESC');
        return [$pages, $byTitle];
    }
}
?>
