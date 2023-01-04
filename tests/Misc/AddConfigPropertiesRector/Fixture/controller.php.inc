<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\AddConfigPropertiesRector\Fixture;

class SomeController extends \SilverStripe\Control\Controller
{
    private static $allowed_actions = [];

    private static $not_configured = [];
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\AddConfigPropertiesRector\Fixture;

class SomeController extends \SilverStripe\Control\Controller
{
    /**
     * @config
     */
    private static $allowed_actions = [];

    private static $not_configured = [];
}

?>
