<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRector\Fixture;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class AddOwnsForFileAndImage extends DataObject
{
    private static $has_one = [
        'Image' => Image::class,
        'Attachment' => File::class,
    ];
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRector\Fixture;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class AddOwnsForFileAndImage extends DataObject
{
    private static $owns = ['Image', 'Attachment'];

    private static $has_one = [
        'Image' => Image::class,
        'Attachment' => File::class,
    ];
}

?>
