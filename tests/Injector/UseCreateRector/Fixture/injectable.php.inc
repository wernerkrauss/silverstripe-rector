<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Fixture;

use Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Source\InjectableClass;

class SomeClass
{
    public function run()
    {
        $foo = new InjectableClass();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Fixture;

use Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Source\InjectableClass;

class SomeClass
{
    public function run()
    {
        $foo = \Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Source\InjectableClass::create();
    }
}
?>
