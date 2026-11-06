<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Forms\FormLoadDataFromMergeStrategyRector\Fixture;

use SilverStripe\Forms\Form;

final class FormLoadDataFromMergeStrategy
{
    public function test(Form $form, object $data): void
    {
        $form->loadDataFrom($data, true);
        $form->loadDataFrom($data, false);
    }
}

-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Forms\FormLoadDataFromMergeStrategyRector\Fixture;

use SilverStripe\Forms\Form;

final class FormLoadDataFromMergeStrategy
{
    public function test(Form $form, object $data): void
    {
        $form->loadDataFrom($data, \SilverStripe\Forms\Form::MERGE_CLEAR_MISSING);
        $form->loadDataFrom($data, 0);
    }
}
