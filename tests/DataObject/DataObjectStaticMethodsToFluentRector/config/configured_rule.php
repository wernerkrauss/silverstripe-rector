<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\DataObject\DataObjectStaticMethodsToFluentRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(DataObjectStaticMethodsToFluentRector::class);
};
