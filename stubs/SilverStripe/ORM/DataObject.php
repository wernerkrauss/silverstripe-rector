<?php

namespace SilverStripe\ORM;
use SilverStripe\Core\Config\Configurable;

if (class_exists('SilverStripe\ORM\DataObject')) {
    return;
}
class DataObject
{
    use Configurable;

    public function i18n_plural_name()
    {
    }

    public function plural_name()
    {
    }

    public static function get($class)
    {
    }
}