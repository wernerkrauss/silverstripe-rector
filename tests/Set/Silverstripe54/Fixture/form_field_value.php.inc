<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\FormField;

class MyField extends FormField
{
    public function getValue()
    {
        return $this->Value();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\FormField;

class MyField extends FormField
{
    public function getValue()
    {
        /**
         * @deprecated FormField::Value() has been deprecated. It will be replaced by getFormattedValue() and getValue().
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        return $this->Value();
    }
}
?>
