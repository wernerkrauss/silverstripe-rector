<?php

declare (strict_types=1);


use Netwerkstatt\SilverstripeRector\Set\SilverstripeLevelSetList;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig) : void {
    $rectorConfig->sets([
        SilverstripeSetList::SS_4_0,
        SilverstripeSetList::SS_4_1,
    ]);
};