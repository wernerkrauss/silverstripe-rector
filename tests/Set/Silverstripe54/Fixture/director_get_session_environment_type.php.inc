<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Control\Director;

class MyDirector
{
    public function getEnv()
    {
        return Director::get_session_environment_type();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Control\Director;

class MyDirector
{
    public function getEnv()
    {
        /**
         * @deprecated Director::get_session_environment_type() has been deprecated. Use Director::get_environment_type() instead.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        return Director::get_session_environment_type();
    }
}
?>
