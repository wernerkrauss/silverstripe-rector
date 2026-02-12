<?php

use Netwerkstatt\SilverstripeRector\Rector\Control\ReplaceHasCurrWithCurrRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(ReplaceHasCurrWithCurrRector::class);
};
