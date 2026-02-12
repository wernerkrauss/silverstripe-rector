<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectGetByIdToByIDRector\Fixture;

use SilverStripe\ORM\DataObject;

class MyDataObject extends DataObject
{
    public function getSelf()
    {
        $id = 1;
        return DataObject::get_by_id(self::class, $id);
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectGetByIdToByIDRector\Fixture;

use SilverStripe\ORM\DataObject;

class MyDataObject extends DataObject
{
    public function getSelf()
    {
        $id = 1;
        return self::get()->byID($id);
    }
}
?>
