<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54To60\Fixture;

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

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54To60\Fixture;

use SilverStripe\Control\Director;

class MyDirector
{
    public function getEnv()
    {
        return Director::get_environment_type();
    }
}
?>
