<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\ORM\GetIDListToColumnIDRector\Fixture;

use SilverStripe\ORM\EagerLoadedList;

function eagerLoadedListGetIdList(EagerLoadedList $list)
{
    return $list->getIDList();
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\ORM\GetIDListToColumnIDRector\Fixture;

use SilverStripe\ORM\EagerLoadedList;

function eagerLoadedListGetIdList(EagerLoadedList $list)
{
    return $list->column('ID');
}
?>
