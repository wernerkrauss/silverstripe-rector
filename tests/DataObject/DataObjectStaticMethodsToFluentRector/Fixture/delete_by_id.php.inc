<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectStaticMethodsToFluentRector\Fixture;

use SilverStripe\ORM\DataObject;

DataObject::delete_by_id(DataObject::class, 123);
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectStaticMethodsToFluentRector\Fixture;

use SilverStripe\ORM\DataObject;

DataObject::get(DataObject::class)->setUseCache(true)->byID(123)->delete();
?>
