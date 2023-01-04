<?php
namespace Netwerkstatt\SilverstripeRector\Tests\Misc\AddConfigPropertiesRector\Fixture;

class ExtraClass extends \SilverStripe\ORM\DataObject
{
    private static $db = [];

    private static $foo = 'foo';

    private static $bar = 'baz';

    private static $not_configured = [];
}

?>
-----
<?php
namespace Netwerkstatt\SilverstripeRector\Tests\Misc\AddConfigPropertiesRector\Fixture;

class ExtraClass extends \SilverStripe\ORM\DataObject
{
    /**
     * @config
     */
    private static $db = [];

    /**
     * @config
     */
    private static $foo = 'foo';

    /**
     * @config
     */
    private static $bar = 'baz';

    private static $not_configured = [];
}

?>
