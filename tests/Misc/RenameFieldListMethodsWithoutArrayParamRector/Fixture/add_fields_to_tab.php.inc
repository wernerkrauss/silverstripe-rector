<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RenameFieldListMethodsWithoutArrayParamRector\Fixture;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

class SomeClass
{
    public function getCMSFields() {
        $fields = FieldList::create();
        $myfield = TextField::create('MyField');
        $fields->addFieldsToTab('Root.Main', $myfield);
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
    public function getCMSFields() {
        $fields = FieldList::create();
        $myfield = TextField::create('MyField');
        $fields->addFieldToTab('Root.Main', $myfield);
    }
}
?>
