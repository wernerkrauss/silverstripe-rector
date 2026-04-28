<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\Misc\StaticCallToConfigRector\Fixture;

use SilverStripe\ORM\DataObject;

class MyObject extends DataObject
{
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        self::disable_subclass_access();
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\Misc\StaticCallToConfigRector\Fixture;

use SilverStripe\ORM\DataObject;

class MyObject extends DataObject
{
    /**
     * @config
     */
    private static $subclass_access = false;
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
    }
}

?>
