<?php

namespace SilverStripe\Control;

if (class_exists('SilverStripe\Control\Controller')) {
    return;
}


class Controller
{
    /**
     * @return bool
     */
    public static function has_curr()
    {
    }

    /**
     * @return Controller|null
     */
    public static function curr()
    {
    }
}