<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    //deprecations cms https://docs.silverstripe.org/en/4/changelogs/4.13.0/#silverstripe-cms
    //Deprecated class SilverStripe\CMS\Controllers\SilverStripeNavigatorItem_Unversioned Will be renamed SilverStripe\Admin\Navigator\SilverStripeNavigatorItem_Unversioned

    //Deprecated class SilverStripe\CMS\Controllers\SilverStripeNavigatorItem_StageLink Will be renamed SilverStripe\VersionedAdmin\Navigator\SilverStripeNavigatorItem_StageLink

    //Deprecated class SilverStripe\CMS\Controllers\SilverStripeNavigator Will be renamed SilverStripe\Admin\Navigator\SilverStripeNavigator

    //Deprecated class SilverStripe\CMS\Controllers\SilverStripeNavigatorItem_LiveLink Will be renamed SilverStripe\VersionedAdmin\Navigator\SilverStripeNavigatorItem_LiveLink

    //Deprecated class SilverStripe\CMS\Controllers\SilverStripeNavigatorItem_ArchiveLink Will be renamed SilverStripe\VersionedAdmin\Navigator\SilverStripeNavigatorItem_ArchiveLink

    //Deprecated class SilverStripe\CMS\Controllers\SilverStripeNavigatorItem Will be renamed SilverStripe\Admin\Navigator\SilverStripeNavigatorItem

    //deprecations framework https://docs.silverstripe.org/en/4/changelogs/4.13.0/#silverstripe-framework
    //Deprecated class SilverStripe\Dev\CSVParser Use League\Csv\Reader instead

    //Deprecated class SilverStripe\View\Parsers\Diff Will be replaced with SilverStripe\View\Parsers\HtmlDiff

    //Deprecated method SilverStripe\ORM\Connect\Query::rewind() Will be replaced by getIterator() in CMS 5

    //Deprecated method SilverStripe\ORM\Connect\Query::current() Will be replaced by getIterator() in CMS 5

    //Deprecated method SilverStripe\ORM\Connect\Query::first() Will be replaced by getIterator() in CMS 5

    //Deprecated method SilverStripe\ORM\Connect\Query::key() Will be replaced by getIterator() in CMS 5

    //Deprecated method SilverStripe\ORM\Connect\Query::next() Will be replaced by getIterator() in CMS 5

    //Deprecated method SilverStripe\ORM\Connect\Query::nextRecord() Will be replaced by getIterator() in CMS 5

    //Deprecated method SilverStripe\ORM\Connect\Query::seek() Will be replaced by getIterator() in CMS 5

    //Deprecated method SilverStripe\ORM\Connect\MySQLStatement::seek() Will be replaced by getIterator() in CMS 5

    //Deprecated method SilverStripe\ORM\Connect\MySQLStatement::nextRecord() Will be replaced by getIterator() in CMS 5

    //Deprecated method SilverStripe\ORM\Connect\MySQLQuery::seek() Will be replaced by getIterator() in CMS 5

    //Deprecated method SilverStripe\ORM\Connect\MySQLQuery::nextRecord() Will be replaced by getIterator() in CMS 5

    //Deprecated method SilverStripe\View\Parsers\Diff::compareHTML() Will be replaced with SilverStripe\View\Parsers\HtmlDiff::compareHTML()
};