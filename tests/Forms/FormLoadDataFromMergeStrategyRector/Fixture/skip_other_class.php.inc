<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Forms\FormLoadDataFromMergeStrategyRector\Fixture;

final class OtherObject
{
    public function test(object $object, object $data): void
    {
        $object->loadDataFrom($data, true);
    }
}
