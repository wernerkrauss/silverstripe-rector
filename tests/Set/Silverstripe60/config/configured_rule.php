<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        SilverstripeSetList::SS_6_0,
    ]);
};
