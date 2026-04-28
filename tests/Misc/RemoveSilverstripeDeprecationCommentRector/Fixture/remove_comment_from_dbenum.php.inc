<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RemoveSilverstripeDeprecationCommentRector\Fixture;

use SilverStripe\ORM\FieldType\DBEnum;

class MyEnum extends DBEnum
{
    /**
     * @deprecated DBEnum::flushCache() has been deprecated. Use reset() instead.
     * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
     */
    public function reset()
    {
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RemoveSilverstripeDeprecationCommentRector\Fixture;

use SilverStripe\ORM\FieldType\DBEnum;

class MyEnum extends DBEnum
{
    public function reset()
    {
    }
}
?>
