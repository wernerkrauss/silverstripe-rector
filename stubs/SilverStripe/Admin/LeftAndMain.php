<?php

namespace SilverStripe\Admin;

if (class_exists('SilverStripe\Admin\LeftAndMain')) {
    return;
}

class LeftAndMain extends \SilverStripe\Control\Controller
{
    public function methodSchema(): array { return []; }
    public function Modals(): object { return new \stdClass(); }
}
