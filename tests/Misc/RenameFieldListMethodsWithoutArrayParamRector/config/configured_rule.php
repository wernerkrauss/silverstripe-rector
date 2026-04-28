<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Netwerkstatt\SilverstripeRector\Rector\Misc\RenameFieldListMethodsWithoutArrayParamRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(RenameFieldListMethodsWithoutArrayParamRector::class);
};
