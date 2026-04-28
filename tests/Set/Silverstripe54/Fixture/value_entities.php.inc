<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\TextareaField;

class ValueEntitiesTest
{
    public function test(TextareaField $field)
    {
        $field->ValueEntities();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\TextareaField;

class ValueEntitiesTest
{
    public function test(TextareaField $field)
    {
        /**
         * @deprecated TextareaField::ValueEntities() has been deprecated. Use getFormattedValueEntities() instead.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $field->ValueEntities();
    }
}
?>
