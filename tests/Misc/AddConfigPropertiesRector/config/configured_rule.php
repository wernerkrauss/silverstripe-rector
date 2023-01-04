<?php

declare (strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\AddConfigPropertiesRector\config;

use Netwerkstatt\SilverstripeRector\Rector\Misc\AddConfigPropertiesRector;
use Netwerkstatt\SilverstripeRector\Tests\Misc\AddConfigPropertiesRector\Fixture\ExtraClass;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(
        AddConfigPropertiesRector::class,
        [ExtraClass::class => ['foo', 'bar']]
    );
};
