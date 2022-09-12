<?php

declare (strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\EnsureTableNameIsSetRector\config;

use Netwerkstatt\SilverstripeRector\Rector\DataObject\EnsureTableNameIsSetRector;
use Rector\Config\RectorConfig;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(EnsureTableNameIsSetRector::class);
};
