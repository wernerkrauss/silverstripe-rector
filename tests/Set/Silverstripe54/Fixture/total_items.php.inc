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
        /**
         * @deprecated ListDecorator::TotalItems() has been deprecated. Use getTotalItems() instead.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $count = $list->TotalItems();
        /**
         * @deprecated PaginatedList::TotalItems() has been deprecated. Use getTotalItems() instead.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $count2 = $paginated->TotalItems();
    }
}
?>
