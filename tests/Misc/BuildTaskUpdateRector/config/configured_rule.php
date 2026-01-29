<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\BuildTaskUpdateRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(BuildTaskUpdateRector::class);
};
