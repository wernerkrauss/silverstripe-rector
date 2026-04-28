<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RemoveSilverstripeDeprecationCommentRector\Fixture;

use SilverStripe\ORM\DataObject;

class MyDataObject extends DataObject
{
    public function useDeprecated()
    {
        /**
         * @deprecated DataObject::get_by_id() is deprecated.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        return $this->get_by_id(MyDataObject::class, 1);
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RemoveSilverstripeDeprecationCommentRector\Fixture;

use SilverStripe\ORM\DataObject;

class MyDataObject extends DataObject
{
    public function useDeprecated()
    {
        return $this->get_by_id(MyDataObject::class, 1);
    }
}
?>
