<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceHasCurrWithCurrRector\Fixture;

use SilverStripe\Control\Controller;

class ReturnValue
{
    public function check()
    {
        return Controller::has_curr();
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceHasCurrWithCurrRector\Fixture;

use SilverStripe\Control\Controller;

class ReturnValue
{
    public function check()
    {
        return Controller::curr() !== null;
    }
}

?>
