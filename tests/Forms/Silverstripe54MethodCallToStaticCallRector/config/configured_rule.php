<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Forms\Silverstripe54MethodCallToStaticCallRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(Silverstripe54MethodCallToStaticCallRector::class);
};
