<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\PropertyToConfigRector;
use Netwerkstatt\SilverstripeRector\Rector\ORM\OrderByRandToShuffleRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(OrderByRandToShuffleRector::class);

    $rectorConfig->ruleWithConfiguration(PropertyToConfigRector::class, [
        'SilverStripe\Dev\BuildTask' => [
            'enabled' => [
                'name' => 'is_enabled',
                'visibility' => \PhpParser\Modifiers::PRIVATE | \PhpParser\Modifiers::STATIC,
                'add_config' => true,
            ],
        ],
    ]);
};