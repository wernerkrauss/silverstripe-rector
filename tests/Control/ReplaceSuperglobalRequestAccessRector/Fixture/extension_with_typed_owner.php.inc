<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceSuperglobalRequestAccessRector\Fixture;

use SilverStripe\Control\Controller;
use SilverStripe\Core\Extension;

class ExtensionWithTypedOwner extends Extension
{
    /**
     * @var Controller
     */
    public $owner;

    public function doSomething()
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

use SilverStripe\Control\Controller;
use SilverStripe\Core\Extension;

class ExtensionWithTypedOwner extends Extension
{
    /**
     * @var Controller
     */
    public $owner;

    public function doSomething()
    {
        $foo = $this->getOwner()->getRequest()->getVar('foo');
        $bar = $this->getOwner()->getRequest()->postVar('bar');
        return [$foo, $bar];
    }
}

?>
