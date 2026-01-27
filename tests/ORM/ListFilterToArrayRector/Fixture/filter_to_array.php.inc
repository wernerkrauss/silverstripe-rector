<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\ListFilterToArrayRector\Fixture;

use SilverStripe\ORM\DataList;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;

class MyDataObject extends DataObject
{
}

function filterTest()
{
    /** @var DataList $list */
    $list = MyDataObject::get();
    $list->filter('ID', 1);
    $list->exclude('Title', 'Page');

    /** @var ArrayList $arrayList */
    $arrayList = ArrayList::create();
    $arrayList->filter('Title', 'Home');
    $arrayList->exclude('Status', 'Draft');

    // Should not change if already array
    $list->filter(['ID' => 1]);

    // Should not change if only one argument (could be a filter identifier or something else)
    $list->filter('ID');
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\ListFilterToArrayRector\Fixture;

use SilverStripe\ORM\DataList;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;

class MyDataObject extends DataObject
{
}

function filterTest()
{
    /** @var DataList $list */
    $list = MyDataObject::get();
    $list->filter(['ID' => 1]);
    $list->exclude(['Title' => 'Page']);

    /** @var ArrayList $arrayList */
    $arrayList = ArrayList::create();
    $arrayList->filter(['Title' => 'Home']);
    $arrayList->exclude(['Status' => 'Draft']);

    // Should not change if already array
    $list->filter(['ID' => 1]);

    // Should not change if only one argument (could be a filter identifier or something else)
    $list->filter('ID');
}
?>
