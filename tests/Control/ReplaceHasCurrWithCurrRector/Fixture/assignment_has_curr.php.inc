<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceHasCurrWithCurrRector\Fixture;

use SilverStripe\Control\Controller;

class Assignment
{
    public function check()
    {
        $hasCurr = Controller::has_curr();
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceHasCurrWithCurrRector\Fixture;

use SilverStripe\Control\Controller;

class Assignment
{
    public function check()
    {
        $hasCurr = Controller::curr() !== null;
    }
}

?>
