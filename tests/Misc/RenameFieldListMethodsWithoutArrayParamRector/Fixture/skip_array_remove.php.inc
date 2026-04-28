<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RenameFieldListMethodsWithoutArrayParamRector\Fixture;

use SilverStripe\Forms\FieldList;

class SkipArrayRemove
{
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeFieldsFromTab('Root.Main', ['Content', 'Title']);
    }
}
