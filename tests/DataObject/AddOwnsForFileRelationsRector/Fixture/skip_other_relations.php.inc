<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRector\Fixture;

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

class SkipOtherRelations extends DataObject
{
    private static $has_one = [
        'Owner' => Member::class,
    ];
}

?>
