<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectStaticMethodsToFluentRector\Fixture;

use SilverStripe\ORM\DataObject;

$filter = ['ID' => 1];
$obj = DataObject::get_one(DataObject::class, $filter);
$obj2 = DataObject::get_one(DataObject::class);
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectStaticMethodsToFluentRector\Fixture;

use SilverStripe\ORM\DataObject;

$filter = ['ID' => 1];
$obj = DataObject::get(DataObject::class)->setUseCache(true)->filter($filter)->first();
$obj2 = DataObject::get(DataObject::class)->setUseCache(true)->first();
?>
