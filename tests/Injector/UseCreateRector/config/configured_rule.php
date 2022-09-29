<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector\config;

use Netwerkstatt\SilverstripeRector\Rector\Injector\UseCreateRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(UseCreateRector::class);
};