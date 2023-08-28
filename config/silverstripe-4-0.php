<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\DataObject\EnsureTableNameIsSetRector;
use Rector\Config\RectorConfig;
use Rector\Transform\Rector\Class_\ParentClassToTraitsRector;
use Rector\Transform\ValueObject\ParentClassToTraits;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(EnsureTableNameIsSetRector::class);

    $object_traits = [
        'SilverStripe\Core\Injector\Injectable',
        'SilverStripe\Core\Config\Configurable',
        'SilverStripe\Core\Extensible'
    ];
    $rectorConfig->ruleWithConfiguration(
        ParentClassToTraitsRector::class,
        [
            new ParentClassToTraits('Object', $object_traits),
            new ParentClassToTraits('SS_Object', $object_traits),
        ]
    );
};