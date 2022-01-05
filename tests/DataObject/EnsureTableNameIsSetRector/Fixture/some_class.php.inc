<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\EnsureTableNameIsSetRector\Fixture;

class SomeClass extends \SilverStripe\ORM\DataObject
{
    private static $db = [];
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\EnsureTableNameIsSetRector\Fixture;

class SomeClass extends \SilverStripe\ORM\DataObject
{
    private static $table_name = 'SomeClass';

    private static $db = [];
}

?>
