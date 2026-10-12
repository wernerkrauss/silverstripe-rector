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
        /**
         * @deprecated TextareaField::ValueEntities() has been deprecated. Use getFormattedValueEntities() instead.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        return $field->getFormattedValueEntities();
    }
}
?>
