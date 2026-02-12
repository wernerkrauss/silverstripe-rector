<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceHasCurrWithCurrRector\Fixture;

use SilverStripe\Control\Controller;

class NegatedIf
{
    public function check()
    {
        if (!Controller::has_curr()) {
            return null;
        }
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceHasCurrWithCurrRector\Fixture;

use SilverStripe\Control\Controller;

class NegatedIf
{
    public function check()
    {
        if (Controller::curr() === null) {
            return null;
        }
    }
}

?>
