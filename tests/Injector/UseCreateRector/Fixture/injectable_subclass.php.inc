<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Fixture;

use Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Source\InjectableSubClass;

class SomeClass
{
    public function run()
    {
        $foo = new InjectableSubClass();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Fixture;

use Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Source\InjectableSubClass;

class SomeClass
{
    public function run()
    {
        $foo = \Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Source\InjectableSubClass::create();
    }
}
?>
