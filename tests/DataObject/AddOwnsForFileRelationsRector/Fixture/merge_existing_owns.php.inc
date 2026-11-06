<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRector\Fixture;

use SilverStripe\Assets\File;
use SilverStripe\ORM\DataObject;

class MergeExistingOwns extends DataObject
{
    private static $has_one = [
        'Attachment' => File::class,
        'Preview' => File::class,
    ];

    private static $owns = ['Attachment'];
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRector\Fixture;

use SilverStripe\Assets\File;
use SilverStripe\ORM\DataObject;

class MergeExistingOwns extends DataObject
{
    private static $has_one = [
        'Attachment' => File::class,
        'Preview' => File::class,
    ];

    private static $owns = ['Attachment', 'Preview'];
}

?>
