<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\Form;

final class FormLoadDataMergeStrategy
{
    public function test(Form $form, object $data): void
    {
        $form->loadDataFrom($data, true);
        $form->loadDataFrom($data, false);
        $form->loadDataFrom($data, Form::MERGE_CLEAR_MISSING);
        $form->loadDataFrom($data, 0);
    }
}

-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\Form;

final class FormLoadDataMergeStrategy
{
    public function test(Form $form, object $data): void
    {
        $form->loadDataFrom($data, Form::MERGE_CLEAR_MISSING);
        $form->loadDataFrom($data, 0);
        $form->loadDataFrom($data, Form::MERGE_CLEAR_MISSING);
        $form->loadDataFrom($data, 0);
    }
}
