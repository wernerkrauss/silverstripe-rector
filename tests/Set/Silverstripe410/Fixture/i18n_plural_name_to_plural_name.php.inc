<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe410\Fixture;

use SilverStripe\ORM\DataObject;

class i18n_plural_name_to_plural_name
{
    public function someMethod()
    {
        $obj = new DataObject();
        $name = $obj->i18n_plural_name();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe410\Fixture;

use SilverStripe\ORM\DataObject;

class i18n_plural_name_to_plural_name
{
    public function someMethod()
    {
        $obj = new DataObject();
        $name = $obj->plural_name();
    }
}
?>
