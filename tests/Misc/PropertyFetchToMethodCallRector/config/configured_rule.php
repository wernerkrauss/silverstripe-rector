<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\PropertyFetchToMethodCallRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(PropertyFetchToMethodCallRector::class, [
        'App\Model\User' => [
            'name' => 'getName',
        ],
    ]);
};
