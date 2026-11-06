<?php

namespace SilverStripe\Assets;

if (class_exists('SilverStripe\Assets\Image')) {
    return;
}

class Image extends File
{
}
