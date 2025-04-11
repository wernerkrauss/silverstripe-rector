<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\CodeStyle\Fixture;

class MyExtension extends \SilverStripe\ORM\DataExtension
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

class MyExtension extends \SilverStripe\ORM\DataExtension
{
    public function someMethod()
    {
        $foo = $this->getOwner()->foo;
    }
}

?>
