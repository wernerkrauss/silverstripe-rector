<?php

namespace SilverStripe\Control;

if (class_exists('SilverStripe\Control\HTTPRequest')) {
    return;
}

class HTTPRequest
{
    /**
     * @param string $name
     * @return mixed
     */
    public function getVar($name)
    {
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function postVar($name)
    {
    }
}
