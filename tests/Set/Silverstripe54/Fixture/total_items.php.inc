<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\ORM\ListDecorator;
use SilverStripe\ORM\PaginatedList;

class TotalItemsTest
{
    public function test(ListDecorator $list, PaginatedList $paginated)
    {
        $count = $list->TotalItems();
        $count2 = $paginated->TotalItems();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\ORM\ListDecorator;
use SilverStripe\ORM\PaginatedList;

class TotalItemsTest
{
    public function test(ListDecorator $list, PaginatedList $paginated)
    {
        $count = $list->getTotalItems();
        $count2 = $paginated->getTotalItems();
    }
}
?>
