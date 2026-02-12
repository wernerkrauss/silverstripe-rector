<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceHasCurrWithCurrRector\Fixture;

class SkipOtherClasses
{
    public function check()
    {
        if (\Some\Other\OtherClass::has_curr()) {
            return false;
        }
    }
}

?>
