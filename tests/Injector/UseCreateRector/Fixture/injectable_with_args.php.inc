<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Fixture;

use Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Source\InjectableClass;

class SomeClass
{
    public function run()
    {
        $bar = 42;
        $foo = new InjectableClass('foo', $bar);
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
        $bar = 42;
        $foo = \Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Source\InjectableClass::create('foo', $bar);
    }
}
?>
