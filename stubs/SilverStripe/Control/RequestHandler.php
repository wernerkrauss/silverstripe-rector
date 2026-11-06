<?php

namespace SilverStripe\Control;

if (class_exists('SilverStripe\Control\RequestHandler')) {
    return;
}

class RequestHandler
{
    /**
     * @return HTTPRequest
     */
    public function getRequest()
    {
    }
}
