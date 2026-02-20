<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;

class TinyMCEConfigRename
{
    public function run()
    {
        $config = TinyMCEConfig::get('cms');
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\TinyMCE\TinyMCEConfig;

class TinyMCEConfigRename
{
    public function run()
    {
        $config = TinyMCEConfig::get('cms');
    }
}
?>
