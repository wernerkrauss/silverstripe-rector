<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\StaticCallToConfigRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(StaticCallToConfigRector::class, [
        \SilverStripe\ORM\DataObject::class => [
            'disable_subclass_access' => [
                'property' => 'subclass_access',
                'value' => false,
                'visibility' => \PhpParser\Modifiers::PRIVATE | \PhpParser\Modifiers::STATIC,
                'add_config' => true
            ],
            'enable_subclass_access' => [
                'property' => 'subclass_access',
                'value' => true,
                'visibility' => \PhpParser\Modifiers::PRIVATE | \PhpParser\Modifiers::STATIC,
                'add_config' => true
            ]
        ]
    ]);
};
