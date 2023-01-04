<?php

declare (strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\AddConfigPropertiesRector\config;

use Netwerkstatt\SilverstripeRector\Rector\Misc\AddConfigPropertiesRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(AddConfigPropertiesRector::class);
};
