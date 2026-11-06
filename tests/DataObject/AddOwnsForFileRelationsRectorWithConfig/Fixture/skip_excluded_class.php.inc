<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRectorWithConfig\Fixture;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class SkipExcludedClass extends DataObject
{
    private static $has_one = [
        'Image' => Image::class,
    ];
}

?>
