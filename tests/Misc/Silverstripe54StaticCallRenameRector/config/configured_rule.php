<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\Silverstripe54StaticCallRenameRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(Silverstripe54StaticCallRenameRector::class);
};
