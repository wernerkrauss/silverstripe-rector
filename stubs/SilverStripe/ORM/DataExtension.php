<?php

namespace SilverStripe\ORM;
if (class_exists('SilverStripe\ORM\DataExtension')) {
    return;
}
class DataExtension
{
    public $owner;
    public function getOwner()
    {
    }
}