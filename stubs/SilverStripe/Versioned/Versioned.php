<?php

namespace SilverStripe\Versioned;

if (class_exists('SilverStripe\Versioned\Versioned')) {
    return;
}

class Versioned
{
    /**
     * @deprecated 5.0.0 Use copyVersionToStage() instead
     */
    public function publish($fromStage, $toStage, $createNewVersion = false)
    {
    }

    /**
     * @deprecated 5.0.0 Use publishRecursive() instead
     */
    public function doPublish()
    {
    }

    public function copyVersionToStage($fromStage, $toStage, $createNewVersion = false)
    {
    }

    public function publishRecursive()
    {
    }
}
