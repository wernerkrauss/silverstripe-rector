<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\RemoveSilverstripeDeprecationCommentRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->autoloadPaths([
        __DIR__ . '/../../../../stubs',
    ]);

    $rectorConfig->ruleWithConfiguration(RemoveSilverstripeDeprecationCommentRector::class, [
        \SilverStripe\ORM\DataObject::class . '::get_by_id' => [
            'message' => 'DataObject::get_by_id() is deprecated.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        \SilverStripe\Control\Director::class => [
            'message' => 'Director is deprecated.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        // Test with another one just in case
        'SilverStripe\ORM\FieldType\DBEnum::reset' => [
            'message' => 'DBEnum::flushCache() has been deprecated. Use reset() instead.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
    ]);
};
