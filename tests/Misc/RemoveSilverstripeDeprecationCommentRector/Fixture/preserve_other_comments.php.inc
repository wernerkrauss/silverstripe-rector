<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RemoveSilverstripeDeprecationCommentRector\Fixture;

use SilverStripe\ORM\DataObject;

class MyThirdDataObject extends DataObject
{
    /**
     * This comment should stay.
     * @param string $id
     * @deprecated DataObject::get_by_id() is deprecated.
     * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
     */
    public function useDeprecated($id)
    {
        return $this->get_by_id(MyThirdDataObject::class, $id);
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RemoveSilverstripeDeprecationCommentRector\Fixture;

use SilverStripe\ORM\DataObject;

class MyThirdDataObject extends DataObject
{
    /**
     * This comment should stay.
     * @param string $id
     */
    public function useDeprecated($id)
    {
        return $this->get_by_id(MyThirdDataObject::class, $id);
    }
}
?>
