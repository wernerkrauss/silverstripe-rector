<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\ORM\GetIDListToColumnIDRector\Fixture;

use SilverStripe\ORM\DataList;

function dataListGetIdList(DataList $list)
{
    return $list->getIDList();
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\ORM\GetIDListToColumnIDRector\Fixture;

use SilverStripe\ORM\DataList;

function dataListGetIdList(DataList $list)
{
    return $list->sort(null)->column('ID');
}
?>
