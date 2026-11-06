<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRector\Fixture;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class HasManyAndManyMany extends DataObject
{
    private static $has_many = [
        'Gallery' => Image::class,
    ];

    private static $many_many = [
        'Files' => Image::class,
    ];
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRector\Fixture;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class HasManyAndManyMany extends DataObject
{
    private static $has_many = [
        'Gallery' => Image::class,
    ];

    private static $many_many = [
        'Files' => Image::class,
    ];

    private static $owns = ['Gallery', 'Files'];
}

?>
