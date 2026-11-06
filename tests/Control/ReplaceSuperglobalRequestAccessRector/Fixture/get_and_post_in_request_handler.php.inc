<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceSuperglobalRequestAccessRector\Fixture;

use SilverStripe\Control\RequestHandler;

class GetAndPostInRequestHandler extends RequestHandler
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

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceSuperglobalRequestAccessRector\Fixture;

use SilverStripe\Control\RequestHandler;

class GetAndPostInRequestHandler extends RequestHandler
{
    public function handle()
    {
        $foo = $this->getRequest()->getVar('foo');
        $bar = $this->getRequest()->postVar('bar');
        return [$foo, $bar];
    }
}

?>
