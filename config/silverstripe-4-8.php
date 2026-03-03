<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use Rector\Renaming\ValueObject\RenameStaticMethod;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(RenameStaticMethodRector::class, [
        new RenameStaticMethod('SilverStripe\Core\ClassInfo', 'subclassesFor', 'SilverStripe\Core\ClassInfo', 'getSubclassesFor'),
    ]);
};