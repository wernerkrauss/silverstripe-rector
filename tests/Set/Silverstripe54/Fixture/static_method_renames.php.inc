<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\ORM\FieldType\DBEnum;
use SilverStripe\View\SSViewer;

class StaticMethodRenamesTest
{
    public function test(): void
    {
        SSViewer::flush();
        SSViewer::fromString('template');
        SSViewer::setTemplate('template');
        SSViewer::setParser('parser');
        SSViewer::getParser();
        SSViewer::hasTemplate('template');
        SSViewer::flush_template_cache();
        SSViewer::flush_cacheblock_cache();
        SSViewer::setPartialCacheStore('store');
        SSViewer::getPartialCacheStore();
        SSViewer::includeGeneratedTemplate('template');
        SSViewer::getSubtemplateFor('template');
        SSViewer::parseTemplateContent('content');
        DBEnum::flushCache();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\TemplateEngine\SSTemplateEngine;
use SilverStripe\ORM\FieldType\DBEnum;

class StaticMethodRenamesTest
{
    public function test(): void
    {
        SSTemplateEngine::flush();
        SSTemplateEngine::renderString('template');
        SSTemplateEngine::setTemplate('template');
        SSTemplateEngine::setParser('parser');
        SSTemplateEngine::getParser();
        SSTemplateEngine::hasTemplate('template');
        SSTemplateEngine::flushTemplateCache();
        SSTemplateEngine::flushCacheBlockCache();
        SSTemplateEngine::setPartialCacheStore('store');
        SSTemplateEngine::getPartialCacheStore();
        SSTemplateEngine::includeGeneratedTemplate('template');
        SSTemplateEngine::getSubtemplateFor('template');
        SSTemplateEngine::parseTemplateContent('content');
        DBEnum::reset();
    }
}
?>
