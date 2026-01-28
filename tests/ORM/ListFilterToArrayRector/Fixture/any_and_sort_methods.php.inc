<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\ListFilterToArrayRector\Fixture;

use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;

class MyDataObjectForAny extends DataObject
{
}

function anyMethodsTest()
{
    /** @var DataList $list */
    $list = MyDataObjectForAny::get();
    $list->filterAny('ID', 1);
    $list->excludeAny('Title', 'Page');
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\ListFilterToArrayRector\Fixture;

use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;

class MyDataObjectForAny extends DataObject
{
}

function anyMethodsTest()
{
    /** @var DataList $list */
    $list = MyDataObjectForAny::get();
    $list->filterAny(['ID' => 1]);
    $list->excludeAny(['Title' => 'Page']);
}
?>
