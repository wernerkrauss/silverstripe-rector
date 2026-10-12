<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\ReplaceSilverstripeNullArgumentRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(ReplaceSilverstripeNullArgumentRector::class, [
        [
            'class' => 'SilverStripe\\Core\\Validation\\ValidationResult',
            'method' => 'addError',
            'position' => 2,
            'replacement' => '',
        ],
        [
            'class' => 'SilverStripe\\Forms\\Form',
            'method' => 'sessionMessage',
            'position' => 2,
            'replacement' => 'SilverStripe\\Core\\Validation\\ValidationResult::CAST_TEXT',
        ],
    ]);
    $rectorConfig->importNames();
};
