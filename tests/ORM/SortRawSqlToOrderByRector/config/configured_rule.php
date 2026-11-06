<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\ORM\SortRawSqlToOrderByRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(SortRawSqlToOrderByRector::class);
};
