<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRector\Fixture;

use SilverStripe\Assets\Image;

class SkipNonDataObject
{
    private static $has_one = [
        'Image' => Image::class,
    ];
}

?>
