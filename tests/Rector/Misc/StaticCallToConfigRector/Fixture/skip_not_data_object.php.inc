<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\Misc\StaticCallToConfigRector\Fixture;

class SomeOtherClass
{
    public function someMethod()
    {
        self::disable_subclass_access();
    }
}
?>
