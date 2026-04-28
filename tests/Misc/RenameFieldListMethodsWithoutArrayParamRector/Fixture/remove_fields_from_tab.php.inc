<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RenameFieldListMethodsWithoutArrayParamRector\Fixture;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

class SomeClass
{
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeFieldsFromTab('Root.Main', 'Content');
    }
}
?>
-----
<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RenameFieldListMethodsWithoutArrayParamRector\Fixture;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

class SomeClass
{
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeFieldFromTab('Root.Main', 'Content');
    }
}
?>
