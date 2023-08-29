<?php

namespace SilverStripe\ORM;
use SilverStripe\Core\Extension;

if (class_exists('SilverStripe\ORM\DataExtension')) {
    return;
}
class DataExtension extends Extension
{
    public $owner;
    public function getOwner()
    {
    }
}