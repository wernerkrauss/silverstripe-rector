<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Forms\FormLoadDataFromMergeStrategyRector\Fixture;

use SilverStripe\Forms\Form;

final class OtherMethod
{
    public function test(Form $form): bool
    {
        return $form->validate();
    }
}
