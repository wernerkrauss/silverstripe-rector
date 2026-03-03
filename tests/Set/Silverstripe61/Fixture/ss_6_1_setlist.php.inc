<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe61\Fixture;

use SilverStripe\ORM\DataObject;

class MyDataObject extends DataObject
{
    public function doSomething()
    {
        $obj = DataObject::get_by_id(self::class, 1);
        $obj2 = DataObject::get_one(self::class, ['ID' => 2]);
        DataObject::delete_by_id(self::class, 3);
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe61\Fixture;

use SilverStripe\ORM\DataObject;

class MyDataObject extends DataObject
{
    public function doSomething()
    {
        $obj = DataObject::get(self::class)->setUseCache(true)->byID(1);
        $obj2 = DataObject::get(self::class)->setUseCache(true)->filter(['ID' => 2])->first();
        DataObject::get(self::class)->setUseCache(true)->byID(3)->delete();
    }
}
?>
