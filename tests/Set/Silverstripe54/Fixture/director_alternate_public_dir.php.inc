<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Control\Director;

class MyClass
{
    public function useProp()
    {
        return Director::$alternate_public_dir;
    }

    public function setProp($val)
    {
        Director::$alternate_public_dir = $val;
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Control\Director;

class MyClass
{
    public function useProp()
    {
        /**
         * @deprecated The Director.alternate_public_dir configuration property has been deprecated. It will be removed without equivalent functionality to replace it.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        return Director::$alternate_public_dir;
    }

    public function setProp($val)
    {
        /**
         * @deprecated The Director.alternate_public_dir configuration property has been deprecated. It will be removed without equivalent functionality to replace it.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        Director::$alternate_public_dir = $val;
    }
}
?>
