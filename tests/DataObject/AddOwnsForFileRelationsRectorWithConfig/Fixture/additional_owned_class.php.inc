<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRectorWithConfig\Fixture;

use SilverStripe\ORM\DataObject;

class AdditionalOwnedClass extends DataObject
{
    private static $has_one = [
        'Document' => 'Vendor\Module\Document',
    ];
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRectorWithConfig\Fixture;

use SilverStripe\ORM\DataObject;

class AdditionalOwnedClass extends DataObject
{
    private static $owns = ['Document'];

    private static $has_one = [
        'Document' => 'Vendor\Module\Document',
    ];
}

?>
