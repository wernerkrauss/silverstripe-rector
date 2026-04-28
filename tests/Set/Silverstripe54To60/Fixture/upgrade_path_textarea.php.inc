<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54To60\Fixture;

use SilverStripe\Forms\TextareaField;

class MyForm
{
    public function getFields()
    {
        $field = new TextareaField('MyText');
        return $field->ValueEntities();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54To60\Fixture;

use SilverStripe\Forms\TextareaField;

class MyForm
{
    public function getFields()
    {
        $field = new TextareaField('MyText');
        return $field->getFormattedValueEntities();
    }
}
?>
