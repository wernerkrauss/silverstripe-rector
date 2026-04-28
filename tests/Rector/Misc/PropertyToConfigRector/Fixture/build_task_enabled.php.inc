<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\Misc\PropertyToConfigRector\Fixture;

use SilverStripe\Dev\BuildTask;

class MyTask extends BuildTask
{
    protected $enabled = true;
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\Misc\PropertyToConfigRector\Fixture;

use SilverStripe\Dev\BuildTask;

class MyTask extends BuildTask
{
    /**
     * @config
     */
    private static $is_enabled = true;
}

?>
