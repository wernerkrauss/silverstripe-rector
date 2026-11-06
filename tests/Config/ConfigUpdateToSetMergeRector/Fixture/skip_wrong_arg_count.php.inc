<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Config\ConfigUpdateToSetMergeRector\Fixture;

use SilverStripe\Core\Config\Config;

class SkipWrongArgCount
{
    public function configure()
    {
        Config::inst()->update('MyClass');
    }
}

?>
