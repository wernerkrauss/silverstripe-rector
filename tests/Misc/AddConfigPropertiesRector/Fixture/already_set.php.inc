<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\AddConfigPropertiesRector\Fixture;

class SomeGoodClass extends \SilverStripe\ORM\DataObject
{
    /**
     * @config
     */
    private static $db = [];

    /**
     * @config
     */
    private static $has_one = [];

    private static $not_configured = [];
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\AddConfigPropertiesRector\Fixture;

class SomeGoodClass extends \SilverStripe\ORM\DataObject
{
    /**
     * @config
     */
    private static $db = [];

    /**
     * @config
     */
    private static $has_one = [];

    private static $not_configured = [];
}

?>
