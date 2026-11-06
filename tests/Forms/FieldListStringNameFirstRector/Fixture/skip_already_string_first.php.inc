<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Forms\FieldListStringNameFirstRector\Fixture;

use SilverStripe\Forms\FieldList;

class SkipAlreadyStringFirst
{
    public function updateFields(FieldList $fields, $myField)
    {
        $fields->insertAfter('Title', $myField);
    }
}

?>
