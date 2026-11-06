<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRectorWithConfig\Fixture;

use SilverStripe\Assets\File;
use SilverStripe\ORM\DataObject;

class SkipExcludedRelation extends DataObject
{
    private static $has_one = [
        'SecretFile' => File::class,
        'PublicFile' => File::class,
    ];
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRectorWithConfig\Fixture;

use SilverStripe\Assets\File;
use SilverStripe\ORM\DataObject;

class SkipExcludedRelation extends DataObject
{
    private static $has_one = [
        'SecretFile' => File::class,
        'PublicFile' => File::class,
    ];

    private static $owns = ['PublicFile'];
}

?>
