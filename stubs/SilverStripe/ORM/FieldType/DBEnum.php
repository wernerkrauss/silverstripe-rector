<?php

namespace SilverStripe\ORM\FieldType;

if (class_exists('SilverStripe\ORM\FieldType\DBEnum')) {
    return;
}

class DBEnum
{
    public function reset()
    {
    }
}
