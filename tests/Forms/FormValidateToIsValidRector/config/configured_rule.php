<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Forms\FormValidateToIsValidRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(FormValidateToIsValidRector::class);
};
