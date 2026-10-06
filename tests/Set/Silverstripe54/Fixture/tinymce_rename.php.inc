<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Admin\Forms\TinyMCEConfig;
use SilverStripe\Admin\Forms\TinyMCECombinedGenerator;
use SilverStripe\Admin\Forms\TinyMCEScriptGenerator;

class TinyMCETest
{
    public function test()
    {
        $config = TinyMCEConfig::get('cms');
        $generator = new TinyMCECombinedGenerator();
        $script = new TinyMCEScriptGenerator();
    }
}
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\TinyMCE\TinyMCEConfig;
use SilverStripe\TinyMCE\TinyMCECombinedGenerator;
use SilverStripe\TinyMCE\TinyMCEScriptGenerator;

class TinyMCETest
{
    public function test()
    {
        $config = TinyMCEConfig::get('cms');
        $generator = new TinyMCECombinedGenerator();
        $script = new TinyMCEScriptGenerator();
    }
}
