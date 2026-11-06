<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\DataObject\AddOwnsForFileRelationsRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(AddOwnsForFileRelationsRector::class);
};
