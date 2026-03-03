<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\SilverstripeDeprecationCommentRector;
use Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Source\ClassWithDeprecatedMethod;
use Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Source\DeprecatedClass;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(SilverstripeDeprecationCommentRector::class, [
        DeprecatedClass::class => [
            'message' => 'This class is deprecated.',
            'link' => 'https://docs.silverstripe.org/deprecated-class',
        ],
        ClassWithDeprecatedMethod::class . '::deprecatedMethod' => [
            'message' => 'This method is deprecated.',
            'link' => 'https://docs.silverstripe.org/deprecated-method',
        ],
    ]);
};
