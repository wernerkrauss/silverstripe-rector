<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceSuperglobalRequestAccessRectorWithCurrFallback\Fixture;

class ControllerCurrFallback
{
    public function handle()
    {
        $foo = $_GET['foo'];
        $bar = $_POST['bar'];
        return [$foo, $bar];
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceSuperglobalRequestAccessRectorWithCurrFallback\Fixture;

class ControllerCurrFallback
{
    public function handle()
    {
        $foo = \SilverStripe\Control\Controller::curr()?->getRequest()->getVar('foo');
        $bar = \SilverStripe\Control\Controller::curr()?->getRequest()->postVar('bar');
        return [$foo, $bar];
    }
}

?>
