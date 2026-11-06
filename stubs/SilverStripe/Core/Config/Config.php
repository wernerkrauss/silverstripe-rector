<?php

namespace SilverStripe\Core\Config;

if (class_exists('SilverStripe\Core\Config\Config')) {
    return;
}

class Config
{
    public static function inst(): self
    {
        return new self();
    }

    public static function modify(): self
    {
        return new self();
    }

    /**
     * @deprecated 5.0.0 Use Config::modify()->set() or Config::modify()->merge() instead
     */
    public function update($class, $name, $value)
    {
    }

    public function set($class, $name, $value)
    {
    }

    public function merge($class, $name, $value)
    {
    }
}
