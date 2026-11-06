<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Forms\FormLoadDataFromMergeStrategyRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(FormLoadDataFromMergeStrategyRector::class);
};
