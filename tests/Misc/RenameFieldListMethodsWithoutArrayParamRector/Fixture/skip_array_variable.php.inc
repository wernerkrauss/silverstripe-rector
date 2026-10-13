<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RenameFieldListMethodsWithoutArrayParamRector\Fixture;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormField;

class SkipArrayVariable
{
    public function updateCMSFields(FieldList $fields)
    {
        $newFields = [
            FormField::create('FirstField'),
            FormField::create('SecondField'),
        ];

        $fields->addFieldsToTab('Root.Main', $newFields);

        $newFields = ['Content', 'Title'];
        $fields->removeFieldsFromTab('Root.Main', $newFields);
    }
}
