<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\Fixture;

class NotInjectable
{
}

class SomeClass
{
    public function run()
    {
        new NotInjectable();
    }
}
