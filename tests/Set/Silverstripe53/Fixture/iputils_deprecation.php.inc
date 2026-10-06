<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe53\Fixture;

use SilverStripe\Control\Util\IPUtils;

class MyClass
{
    public function checkIp()
    {
        IPUtils::is_ipv4('127.0.0.1');
    }
}
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe53\Fixture;

use SilverStripe\Control\Util\IPUtils;

class MyClass
{
    public function checkIp()
    {
        /**
         * @deprecated IPUtils has been deprecated and its usage has been replaced with the IPUtils class from symfony/http-foundation.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.3.0/#api-changes
         */
        IPUtils::is_ipv4('127.0.0.1');
    }
}
