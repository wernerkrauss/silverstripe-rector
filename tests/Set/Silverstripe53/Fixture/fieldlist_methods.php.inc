<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe53\Fixture;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class SomeExtension extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Main', TextField::create('MyField'));
        $fields->removeFieldsFromTab('Root.Main', 'Content');

        $fields->addFieldsToTab('Root.Main', [TextField::create('OtherField')]);
        $fields->removeFieldsFromTab('Root.Main', ['Title', 'Description']);
    }
}
?>
-----
<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe53\Fixture;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

class SomeExtension extends Extension
{
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab('Root.Main', TextField::create('MyField'));
        $fields->removeFieldFromTab('Root.Main', 'Content');

        $fields->addFieldsToTab('Root.Main', [TextField::create('OtherField')]);
        $fields->removeFieldsFromTab('Root.Main', ['Title', 'Description']);
    }
}
?>
