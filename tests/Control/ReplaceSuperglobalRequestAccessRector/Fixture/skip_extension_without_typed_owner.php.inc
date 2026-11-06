<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceSuperglobalRequestAccessRector\Fixture;

use SilverStripe\Core\Extension;

class SkipExtensionWithoutTypedOwner extends Extension
{
    public function doSomething()
    {
        return $_POST['bar'];
    }
}

?>
