<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\RenameAddFieldsToTabWithoutArrayParamRector;
use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\Name\RenameClassRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(RenameAddFieldsToTabWithoutArrayParamRector::class);

    $rectorConfig->ruleWithConfiguration(RenameClassRector::class, [
        'SilverStripe\ORM\DataExtension' => 'SilverStripe\Core\Extension',
        'SilverStripe\CMS\Model\SiteTreeExtension' => 'SilverStripe\Core\Extension',
        'SilverStripe\Admin\LeftAndMainExtension' => 'SilverStripe\Core\Extension',
    ]);
    $rectorConfig->importNames();
    $rectorConfig->removeUnusedImports();
};
