<?php

namespace SilverStripe\ORM;
use SilverStripe\Core\Config\Configurable;

if (class_exists('SilverStripe\ORM\DataObject')) {
    return;
}
class DataObject
{
    use Configurable;
}