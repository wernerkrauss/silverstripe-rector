<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\ORM\GetIDListToColumnIDRector;
use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(RenameMethodRector::class, [
        new MethodCallRename('SilverStripe\Forms\FieldList', 'dataFields', 'getDataFields'),
    ]);
    $rectorConfig->rule(GetIDListToColumnIDRector::class);
};