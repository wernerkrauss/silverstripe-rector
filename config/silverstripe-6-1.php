<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\DataObject\DataObjectStaticMethodsToFluentRector;
use Netwerkstatt\SilverstripeRector\Rector\Misc\SilverstripeDeprecationCommentRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(DataObjectStaticMethodsToFluentRector::class);
    $rectorConfig->ruleWithConfiguration(SilverstripeDeprecationCommentRector::class, [
        'SilverStripe\UserForms\Extension\UpgradePolymorphicExtension' => [
            'message' => 'UpgradePolymorphicExtension has been deprecated and will be removed without equivalent functionality',
            'link' => 'https://docs.silverstripe.org/en/6/changelogs/6.1.0/#api-changes',
        ],
    ]);
};