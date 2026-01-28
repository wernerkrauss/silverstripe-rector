<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectGetByIdToByIDRector\Fixture;

use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;

class MyDataObject extends DataObject
{
}

function getByIdTest()
{
    $id = 1;
    // Positive cases
    $obj1 = DataObject::get_by_id(MyDataObject::class, $id);
    $obj2 = DataObject::get_by_id(SiteTree::class, 123);
    $obj3 = DataObject::get_by_id('SilverStripe\CMS\Model\SiteTree', $id);

    // Negative cases
    $list = DataObject::get(MyDataObject::class);
    $other = SomeOtherClass::get_by_id(MyDataObject::class, $id);

    // More cases
    $obj4 = DataObject::get_by_id('MyPage', $id);
    $obj5 = DataObject::get_by_id(self::class, $id);
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectGetByIdToByIDRector\Fixture;

use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;

class MyDataObject extends DataObject
{
}

function getByIdTest()
{
    $id = 1;
    // Positive cases
    $obj1 = \Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectGetByIdToByIDRector\Fixture\MyDataObject::get()->byID($id);
    $obj2 = \SilverStripe\CMS\Model\SiteTree::get()->byID(123);
    $obj3 = \SilverStripe\CMS\Model\SiteTree::get()->byID($id);

    // Negative cases
    $list = DataObject::get(MyDataObject::class);
    $other = SomeOtherClass::get_by_id(MyDataObject::class, $id);

    // More cases
    $obj4 = \MyPage::get()->byID($id);
    $obj5 = self::get()->byID($id);
}
?>
