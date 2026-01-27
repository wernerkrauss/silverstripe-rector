<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\ORM\ListFilterToArrayRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(ListFilterToArrayRector::class);
};
