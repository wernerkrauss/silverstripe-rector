<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54To60\Fixture;

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

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54To60\Fixture;

use SilverStripe\Forms\FormField;

class MyField extends FormField
{
    public function getValue()
    {
        return $this->getFormattedValue();
    }
}
?>
