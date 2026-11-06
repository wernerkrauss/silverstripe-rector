<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\Control\Controller;

class SuperglobalRequestAccess extends Controller
{
    public function index()
    {
        $foo = $_GET['foo'];
        $bar = $_POST['bar'];
        return [$foo, $bar];
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\Control\Controller;

class SuperglobalRequestAccess extends Controller
{
    public function index()
    {
        $foo = $this->getRequest()->getVar('foo');
        $bar = $this->getRequest()->postVar('bar');
        return [$foo, $bar];
    }
}
?>
