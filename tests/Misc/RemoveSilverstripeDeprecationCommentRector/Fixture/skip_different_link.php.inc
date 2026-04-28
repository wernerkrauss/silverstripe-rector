<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RemoveSilverstripeDeprecationCommentRector\Fixture;

use SilverStripe\ORM\DataObject;

class MyOtherDataObject extends DataObject
{
    public function useDeprecated()
    {
        /**
         * @deprecated Some other message.
         * See: https://different-link.com
         */
        return $this->get_by_id(MyOtherDataObject::class, 1);
    }
}
?>
