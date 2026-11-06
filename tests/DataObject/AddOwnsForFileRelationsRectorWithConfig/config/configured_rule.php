<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\DataObject\AddOwnsForFileRelationsRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(AddOwnsForFileRelationsRector::class, [
        AddOwnsForFileRelationsRector::ADDITIONAL_OWNED_CLASSES => ['Vendor\Module\Document'],
        AddOwnsForFileRelationsRector::EXCLUDE_CLASSES => [
            \Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRectorWithConfig\Fixture\SkipExcludedClass::class,
        ],
        AddOwnsForFileRelationsRector::EXCLUDE_RELATIONS => ['SecretFile'],
    ]);
};
