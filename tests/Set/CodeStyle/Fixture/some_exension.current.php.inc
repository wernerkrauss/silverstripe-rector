<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\CodeStyle\Fixture;

class MyExtension extends \SilverStripe\Core\Extension
{
    public function someMethod()
    {
        $foo = $this->owner->foo;
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\CodeStyle\Fixture;

class MyExtension extends \SilverStripe\Core\Extension
{
    public function someMethod()
    {
        $foo = $this->getOwner()->foo;
    }
}

?>
