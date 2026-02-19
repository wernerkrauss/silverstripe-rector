<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Config\StatToConfigGetRector\Fixture;

use SilverStripe\ORM\DataObject;

class MyClass extends DataObject
{
    public function myMethod()
    {
        $this->stat('foo');
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Config\StatToConfigGetRector\Fixture;

use SilverStripe\ORM\DataObject;

class MyClass extends DataObject
{
    public function myMethod()
    {
        static::config()->get('foo');
    }
}
?>
