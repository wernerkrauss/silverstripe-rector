<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54To60\Fixture;

use SilverStripe\ORM\PaginatedList;

class MyPageList
{
    public function showTotal(PaginatedList $list)
    {
        return $list->TotalItems();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54To60\Fixture;

use SilverStripe\Model\List\PaginatedList;

class MyPageList
{
    public function showTotal(PaginatedList $list)
    {
        return $list->getTotalItems();
    }
}
?>
