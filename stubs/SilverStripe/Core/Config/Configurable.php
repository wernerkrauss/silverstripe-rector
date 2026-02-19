<?php

namespace SilverStripe\Core\Config;

if (trait_exists('SilverStripe\Core\Config\Configurable')) {
    return;
}

trait Configurable
{
    /**
     * @param string $name
     * @param bool $uninherited
     * @return mixed
     * @deprecated 4.0.0 Use self::config()->get($name) instead
     */
    public function stat($name, $uninherited = false)
    {
        return null;
    }
}
