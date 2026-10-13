<?php

namespace SilverStripe\Logging;

class HTTPOutputHandler
{
    public function isCli(): bool
    {
        return false;
    }
}
