<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RenameAddFieldsToTabWithoutArrayParamRector\Fixture;

class ArrayVariableClass extends \SilverStripe\ORM\DataObject
{
    public function updateCMSFields(\SilverStripe\Forms\FieldList $fields)
    {
        $newFields = [
            \SilverStripe\Forms\FormField::create('FirstField'),
            \SilverStripe\Forms\FormField::create('SecondField'),
        ];

        $fields->addFieldsToTab('Root.Main', $newFields);
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RenameAddFieldsToTabWithoutArrayParamRector\Fixture;

class ArrayVariableClass extends \SilverStripe\ORM\DataObject
{
    public function updateCMSFields(\SilverStripe\Forms\FieldList $fields)
    {
        $newFields = [
            \SilverStripe\Forms\FormField::create('FirstField'),
            \SilverStripe\Forms\FormField::create('SecondField'),
        ];

        $fields->addFieldsToTab('Root.Main', $newFields);
    }
}

?>
