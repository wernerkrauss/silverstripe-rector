<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RenameAddFieldsToTabWithoutArrayParamRector\Fixture;

class SomeClass extends \SilverStripe\ORM\DataObject
{
    public function getCMSFields() {
        $myfield = FormField::create();
        $fields->addFieldsToTab('Root.Main', [$myfield]);
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RenameAddFieldsToTabWithoutArrayParamRector\Fixture;

class SomeClass extends \SilverStripe\ORM\DataObject
{
    public function getCMSFields() {
        $myfield = FormField::create();
        $fields->addFieldsToTab('Root.Main', [$myfield]);
    }
}

?>
