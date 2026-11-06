<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Forms\FieldListStringNameFirstRector\Fixture;

class SkipOtherList
{
    public function insertAfter($field, $name)
    {
    }
}

class SkipOtherClass
{
    public function update(SkipOtherList $list, $myField)
    {
        $list->insertAfter($myField, 'Title');
    }
}

?>
