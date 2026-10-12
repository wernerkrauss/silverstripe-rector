<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\CMS\Controllers\LeftAndMainPageIconsExtension;
use SilverStripe\CMS\Model\CurrentPageIdentifier;
use SilverStripe\View\SSViewer_BasicIteratorSupport;
use SilverStripe\View\SSViewer_DataPresenter;
use SilverStripe\View\SSViewer_Scope;
use SilverStripe\View\SSTemplateParseException;
use SilverStripe\View\SSTemplateParser;
use SilverStripe\View\TemplateIteratorProvider;
use SilverStripe\View\TemplateParser;

final class TemplateCmsClassRenames
{
    public function test(): void
    {
        $scope = new SSViewer_Scope();
        $presenter = new SSViewer_DataPresenter();
        $iterator = new SSViewer_BasicIteratorSupport();
        $parseException = new SSTemplateParseException();
        $templateParser = new SSTemplateParser();
        $provider = new TemplateIteratorProvider();
        $parser = new TemplateParser();
        $identifier = new CurrentPageIdentifier();
        $icons = new LeftAndMainPageIconsExtension();
    }
}
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\TemplateEngine\ScopeManager;
use SilverStripe\TemplateEngine\BasicIteratorSupport;
use SilverStripe\TemplateEngine\Exception\SSTemplateParseException;
use SilverStripe\TemplateEngine\SSTemplateParser;
use SilverStripe\TemplateEngine\TemplateIteratorProvider;
use SilverStripe\TemplateEngine\TemplateParser;
use SilverStripe\CMS\Model\CurrentRecordIdentifier;
use SilverStripe\CMS\Controllers\LeftAndMainRecordIconsExtension;


final class TemplateCmsClassRenames
{
    public function test(): void
    {
        $scope = new ScopeManager();
        $presenter = new ScopeManager();
        $iterator = new BasicIteratorSupport();
        $parseException = new SSTemplateParseException();
        $templateParser = new SSTemplateParser();
        $provider = new TemplateIteratorProvider();
        $parser = new TemplateParser();
        $identifier = new CurrentRecordIdentifier();
        $icons = new LeftAndMainRecordIconsExtension();
    }
}
