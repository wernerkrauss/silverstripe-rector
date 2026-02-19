<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Config\StatToConfigGetRector\Fixture;

class OtherClass
{
    public function stat($name)
    {
        return $name;
    }

    public function myMethod()
    {
        $this->stat('foo');
    }
}
?>
