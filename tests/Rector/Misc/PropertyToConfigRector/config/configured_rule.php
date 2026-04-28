<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\PropertyToConfigRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(PropertyToConfigRector::class, [
        \SilverStripe\Dev\BuildTask::class => [
            'enabled' => [
                'name' => 'is_enabled',
                'visibility' => \PhpParser\Modifiers::PRIVATE | \PhpParser\Modifiers::STATIC,
                'add_config' => true,
            ],
        ],
    ]);
};
