<?php
declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Injector\UseCreateRector;
use Rector\Config\RectorConfig;
use Rector\Transform\Rector\Assign\PropertyFetchToMethodCallRector;
use Rector\Transform\ValueObject\PropertyFetchToMethodCall;

return static function (RectorConfig $rectorConfig) : void {
    $rectorConfig->rule(UseCreateRector::class);

    // ->owner => ->getOwner()
    // $rectorConfig->ruleWithConfiguration(
    //     PropertyFetchToMethodCallRector::class,
    //     [
    //         new PropertyFetchToMethodCall(
    //             'SilverStripe\Core\Extension',
    //             'owner',
    //             'getOwner',
    //         )
    //     ]
    // );
};
