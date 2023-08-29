<?php

declare (strict_types=1);


use Netwerkstatt\SilverstripeRector\Set\SilverstripeLevelSetList;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig) : void {
    $rectorConfig->sets([
        SilverstripeLevelSetList::UP_TO_SS_4_12,
        SilverstripeSetList::SS_4_13
    ]);
};