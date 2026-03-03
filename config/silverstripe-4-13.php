<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\SilverstripeDeprecationCommentRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(SilverstripeDeprecationCommentRector::class, [
        'SilverStripe\CMS\Tasks\RemoveOrphanedPagesTask' => [
            'message' => 'RemoveOrphanedPagesTask has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/4/changelogs/4.13.0/#api-deprecated',
        ],
        'SilverStripe\CMS\Tasks\MigrateSiteTreeLinkingTask' => [
            'message' => 'MigrateSiteTreeLinkingTask has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/4/changelogs/4.13.0/#api-deprecated',
        ],
        'SilverStripe\CMS\Tasks\SiteTreeMaintenanceTask' => [
            'message' => 'SiteTreeMaintenanceTask has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/4/changelogs/4.13.0/#api-deprecated',
        ],
        'SilverStripe\ORM\DataList::getGenerator' => [
            'message' => 'DataList::getGenerator() has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/4/changelogs/4.13.0/#api-deprecated',
        ],
    ]);
};