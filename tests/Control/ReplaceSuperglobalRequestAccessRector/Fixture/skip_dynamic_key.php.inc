<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceSuperglobalRequestAccessRector\Fixture;

use SilverStripe\Control\Controller;

class SkipDynamicKey extends Controller
{
    public function index($key)
    {
        return $_GET[$key];
    }
}

?>
