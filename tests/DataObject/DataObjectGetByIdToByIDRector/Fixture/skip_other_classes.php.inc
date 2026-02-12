<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectGetByIdToByIDRector\Fixture;

use SilverStripe\ORM\DataObject;

function getByIdNegative()
{
    $id = 1;
    $list = DataObject::get(MyDataObject::class);
    $other = SomeOtherClass::get_by_id(MyDataObject::class, $id);
}
?>
