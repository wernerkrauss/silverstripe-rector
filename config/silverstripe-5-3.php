<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\RenameFieldListMethodsWithoutArrayParamRector;
use Netwerkstatt\SilverstripeRector\Rector\Misc\SilverstripeDeprecationCommentRector;
use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\Name\RenameClassRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(RenameFieldListMethodsWithoutArrayParamRector::class);

    $rectorConfig->ruleWithConfiguration(SilverstripeDeprecationCommentRector::class, [
        'DNADesign\Elemental\Models\BaseElement::getDescription' => [
            'message' => 'BaseElement::getDescription() has been deprecated. To update or get the CMS description of elemental blocks, use the description configuration property and the localisation API.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.3.0/#api-changes',
        ],
        'SilverStripe\Control\Util\IPUtils::is_ipv4' => [
            'message' => 'IPUtils has been deprecated and its usage has been replaced with the IPUtils class from symfony/http-foundation.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.3.0/#api-changes',
        ],
        'SilverStripe\Control\Util\IPUtils::is_ipv6' => [
            'message' => 'IPUtils has been deprecated and its usage has been replaced with the IPUtils class from symfony/http-foundation.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.3.0/#api-changes',
        ],
    ]);

    $rectorConfig->ruleWithConfiguration(RenameClassRector::class, [
        'SilverStripe\ORM\DataExtension' => 'SilverStripe\Core\Extension',
        'SilverStripe\CMS\Model\SiteTreeExtension' => 'SilverStripe\Core\Extension',
        'SilverStripe\Admin\LeftAndMainExtension' => 'SilverStripe\Core\Extension',
    ]);
    $rectorConfig->importNames();
    $rectorConfig->removeUnusedImports();
};
