<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\ORM\GetIDListToColumnIDRector\Fixture;

use SilverStripe\ORM\Relation;

function relationGetIdList(Relation $list)
{
    return $list->getIDList();
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\ORM\GetIDListToColumnIDRector\Fixture;

use SilverStripe\ORM\Relation;

function relationGetIdList(Relation $list)
{
    return $list->sort(null)->column('ID');
}
?>
