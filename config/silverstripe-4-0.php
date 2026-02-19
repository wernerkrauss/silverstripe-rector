<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Config\StatToConfigGetRector;
use Netwerkstatt\SilverstripeRector\Rector\DataObject\EnsureTableNameIsSetRector;
use Netwerkstatt\SilverstripeRector\Rector\Misc\ParentClassToTraits;
use Netwerkstatt\SilverstripeRector\Rector\Misc\ParentClassToTraitsRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(EnsureTableNameIsSetRector::class);
    $rectorConfig->rule(StatToConfigGetRector::class);

    //pre 4.0
    $object_traits = [
        'SilverStripe\Core\Injector\Injectable',
        'SilverStripe\Core\Config\Configurable',
        'SilverStripe\Core\Extensible'
    ];
    $rectorConfig->ruleWithConfiguration(
        ParentClassToTraitsRector::class,
        [
            new ParentClassToTraits('Object', $object_traits),
            new ParentClassToTraits('SS_Object', $object_traits),
        ]
    );


    //4.0 https://docs.silverstripe.org/en/4/changelogs/4.0.0/#dataobject-versioned
    //Versioned::publish Replaced by Versioned::copyVersionToStage

    //Versioned::doPublish Replaced by Versioned::publishRecursive

    //The Config::inst()->update() method is deprecated, and replaced with Config::modify()->set() and Config::modify()->merge() to respectively replace and merge config.

    //https://docs.silverstripe.org/en/4/changelogs/4.0.0/#overview-general

    //SiteTree.alternatePreviewLink is deprecated. Use updatePreviewLink instead.

    //Deprecated Member::checkPassword(). Use Authenticator::checkPassword() instead

    //Deprecated ClassInfo::baseDataClass(). Use DataObject::getSchema()->baseDataClass() instead.

    //Deprecated ClassInfo::table_for_object_field(). Use DataObject::getSchema()->tableForField() instead

    //https://docs.silverstripe.org/en/4/changelogs/4.0.0/#overview-orm
    //Deprecated SQLQuery in favour SQLSelect

    //Renamed String::NoHTML() to Plain()

    //Removed String::LimitWordCountXML(). Use LimitWordCount() instead.

    //Removed String::BigSummary(). Use Summary() instead.

    //Renamed FormField#createTag() to FormField::create_tag()

    //Permission::flush_permission_cache() renamed to reset() and added to Resettable interface.

    //Renamed Versioned::reading_stage() to set_stage() (throws an error if setting an invalid stage)
    //Renamed Versioned::current_stage() to get_stage()
    //Removed Versioned::get_live_stage(). Use the Versioned::LIVE constant instead.
    //Removed Versioned::getDefaultStage(). Use the Versioned::DRAFT constant instead.


};
