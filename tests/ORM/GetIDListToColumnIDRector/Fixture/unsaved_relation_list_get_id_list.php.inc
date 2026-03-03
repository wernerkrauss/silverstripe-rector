<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\ORM\GetIDListToColumnIDRector\Fixture;

use SilverStripe\ORM\UnsavedRelationList;

function unsavedRelationListGetIdList(UnsavedRelationList $list)
{
    return $list->getIDList();
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\ORM\GetIDListToColumnIDRector\Fixture;

use SilverStripe\ORM\UnsavedRelationList;

function unsavedRelationListGetIdList(UnsavedRelationList $list)
{
    return $list->column('ID');
}
?>
