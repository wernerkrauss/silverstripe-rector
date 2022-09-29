<?php

namespace SilverStripe\Core\Injector;

if (class_exists('SilverStripe\Core\Injector\Injectable')) {
    return;
}

trait Injectable
{
    public static function create()
    {

    }
}