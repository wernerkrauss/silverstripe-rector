<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectGetByIdToByIDRector\Fixture;

use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;

function getByIdTest()
{
    $id = 1;
    $obj2 = DataObject::get_by_id(SiteTree::class, 123);
    $obj3 = DataObject::get_by_id('SilverStripe\CMS\Model\SiteTree', $id);
    $obj4 = DataObject::get_by_id('MyPage', $id);
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectGetByIdToByIDRector\Fixture;

use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;

function getByIdTest()
{
    $id = 1;
    $obj2 = \SilverStripe\CMS\Model\SiteTree::get()->byID(123);
    $obj3 = \SilverStripe\CMS\Model\SiteTree::get()->byID($id);
    $obj4 = \MyPage::get()->byID($id);
}
?>
