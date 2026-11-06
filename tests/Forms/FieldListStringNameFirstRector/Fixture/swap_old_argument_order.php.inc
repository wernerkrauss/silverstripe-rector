<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Forms\FieldListStringNameFirstRector\Fixture;

use SilverStripe\Forms\FieldList;

class SwapOldArgumentOrder
{
    public function updateFields(FieldList $fields, $myField)
    {
        $fields->insertAfter($myField, 'Title');
        $fields->insertBefore($myField, 'Title');
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Forms\FieldListStringNameFirstRector\Fixture;

use SilverStripe\Forms\FieldList;

class SwapOldArgumentOrder
{
    public function updateFields(FieldList $fields, $myField)
    {
        $fields->insertAfter('Title', $myField);
        $fields->insertBefore('Title', $myField);
    }
}

?>
