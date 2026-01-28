<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\ORM\ListSortToArrayRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(ListSortToArrayRector::class);
};
