<?php

namespace SilverStripe\Core;

if (class_exists('SilverStripe\Core\Extension')) {
    return;
}

class Extension
{
    public $owner;
    public function getOwner()
    {
    }
}