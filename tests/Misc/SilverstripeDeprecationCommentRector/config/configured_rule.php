<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\SilverstripeDeprecationCommentRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(SilverstripeDeprecationCommentRector::class, [
        'Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Source\DeprecatedClass' => [
            'message' => 'This class is deprecated.',
            'link' => 'https://docs.silverstripe.org/deprecated-class',
        ],
        'Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Source\ClassWithDeprecatedMethod::deprecatedMethod' => [
            'message' => 'This method is deprecated.',
            'link' => 'https://docs.silverstripe.org/deprecated-method',
        ],
    ]);
};
