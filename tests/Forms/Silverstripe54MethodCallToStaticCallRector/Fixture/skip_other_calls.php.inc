<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Forms\Silverstripe54MethodCallToStaticCallRector\Fixture;

final class UnrelatedCalls
{
    public function test(object $object): void
    {
        $object->isValidEmail('name@example.com');
        $object->isCli();
    }
}
