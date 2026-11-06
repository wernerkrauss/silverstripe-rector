<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\CodeStyle\Fixture;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class AddOwnsForFileRelations extends DataObject
{
    private static $has_one = [
        'Image' => Image::class,
    ];
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\CodeStyle\Fixture;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class AddOwnsForFileRelations extends DataObject
{
    private static $has_one = [
        'Image' => Image::class,
    ];

    private static $owns = ['Image'];
}
?>
