<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Misc\SilverstripeDeprecationCommentRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(SilverstripeDeprecationCommentRector::class, [
        'SilverStripe\Control\Director::alternate_public_dir' => [
            'message' => 'The Director.alternate_public_dir configuration property has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Dev\DevelopmentAdmin' => [
            'message' => 'DevelopmentAdmin has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Dev\DevelopmentAdmin::getRegisteredController' => [
            'message' => 'DevelopmentAdmin::getRegisteredController() has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\View\ViewableData::castingClass' => [
            'message' => 'ViewableData::castingClass() has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\View\ViewableData::escapeTypeForField' => [
            'message' => 'ViewableData::escapeTypeForField() has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\ORM\ListDecorator::TotalItems' => [
            'message' => 'ListDecorator::TotalItems() has been deprecated. Use getTotalItems() instead.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\ORM\PaginatedList::TotalItems' => [
            'message' => 'PaginatedList::TotalItems() has been deprecated. Use getTotalItems() instead.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Forms\TextareaField::ValueEntities' => [
            'message' => 'TextareaField::ValueEntities() has been deprecated. Use getFormattedValueEntities() instead.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Forms\GridField\GridFieldDataColumns::getValueFromRelation' => [
            'message' => 'GridFieldDataColumns::getValueFromRelation() has been deprecated. It will be removed without equivalent functionality to replace it.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Forms\FormField::Value' => [
            'message' => 'FormField::Value() has been deprecated. It will be replaced by getFormattedValue() and getValue().',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
        'SilverStripe\Control\Director::get_session_environment_type' => [
            'message' => 'Director::get_session_environment_type() has been deprecated. Use Director::get_environment_type() instead.',
            'link' => 'https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api',
        ],
    ]);
};
