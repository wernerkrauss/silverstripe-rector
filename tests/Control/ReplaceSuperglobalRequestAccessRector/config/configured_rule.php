<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Control\ReplaceSuperglobalRequestAccessRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(ReplaceSuperglobalRequestAccessRector::class);
};
