<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Config\ConfigUpdateToSetMergeRector\Fixture;

use SilverStripe\Core\Config\Config;

class UpdateToSetAndMerge
{
    public function configure()
    {
        Config::inst()->update('MyClass', 'my_prop', 'value');
        Config::inst()->update('MyClass', 'my_list', ['a' => 'b']);
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Config\ConfigUpdateToSetMergeRector\Fixture;

use SilverStripe\Core\Config\Config;

class UpdateToSetAndMerge
{
    public function configure()
    {
        \SilverStripe\Core\Config\Config::modify()->set('MyClass', 'my_prop', 'value');
        \SilverStripe\Core\Config\Config::modify()->merge('MyClass', 'my_list', ['a' => 'b']);
    }
}

?>
