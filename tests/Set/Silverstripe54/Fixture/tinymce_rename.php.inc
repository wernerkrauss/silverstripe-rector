<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;
use SilverStripe\Forms\HTMLEditor\TinyMCECombinedGenerator;
use SilverStripe\Forms\HTMLEditor\TinyMCEScriptGenerator;

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
