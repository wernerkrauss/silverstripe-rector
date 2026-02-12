<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceHasCurrWithCurrRector\Fixture;

use SilverStripe\Control\Controller;

class SimpleIf
{
    public function check()
    {
        if (Controller::has_curr()) {
            return Controller::curr();
        }
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceHasCurrWithCurrRector\Fixture;

use SilverStripe\Control\Controller;

class SimpleIf
{
    public function check()
    {
        if (Controller::curr() !== null) {
            return Controller::curr();
        }
    }
}

?>
