<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\DataObject\DataObjectGetByIdToByIDRector;
use Netwerkstatt\SilverstripeRector\Rector\Injector\UseCreateRector;
use Netwerkstatt\SilverstripeRector\Rector\Misc\PropertyFetchToMethodCallRector;
use Netwerkstatt\SilverstripeRector\Rector\ORM\ListFilterToArrayRector;
use Netwerkstatt\SilverstripeRector\Rector\ORM\ListSortToArrayRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(UseCreateRector::class);

    // ->owner => ->getOwner()
    $rectorConfig->ruleWithConfiguration(
        PropertyFetchToMethodCallRector::class,
        [
            // class => [property => method]
            SilverStripe\Core\Extension::class => [
                'owner' => 'getOwner',
            ],
        ]
    );

    $rectorConfig->rule(ListFilterToArrayRector::class);
    $rectorConfig->rule(ListSortToArrayRector::class);
    $rectorConfig->rule(DataObjectGetByIdToByIDRector::class);
};
