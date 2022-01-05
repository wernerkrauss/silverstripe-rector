<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\EnsureTableNameIsSetRector\Fixture;

class SomeClass extends \SilverStripe\ORM\DataObject
{
    private static $table_name = 'SomeClass_Modified';

    private static $db = [];
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\EnsureTableNameIsSetRector\Fixture;

class SomeClass extends \SilverStripe\ORM\DataObject
{
    private static $table_name = 'SomeClass_Modified';

    private static $db = [];
}

?>
