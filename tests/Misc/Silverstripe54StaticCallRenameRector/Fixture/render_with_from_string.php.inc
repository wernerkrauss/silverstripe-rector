<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\Silverstripe54StaticCallRenameRector\Fixture;

use SilverStripe\View\SSViewer;

final class RenderWithFromString
{
    public function test($record, string $template): void
    {
        $html = $record->renderWith(SSViewer::fromString('<p>$Title</p>'));
        $html = $record->customise(['Foo' => 'Bar'])->renderWith(SSViewer::fromString($template));
        $exists = SSViewer::hasTemplate(['Page']);
    }
}

-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\Silverstripe54StaticCallRenameRector\Fixture;

use SilverStripe\View\SSViewer;

final class RenderWithFromString
{
    public function test($record, string $template): void
    {
        $html = \SilverStripe\TemplateEngine\SSTemplateEngine::create()->renderString('<p>$Title</p>', \SilverStripe\View\ViewLayerData::create($record));
        $html = \SilverStripe\TemplateEngine\SSTemplateEngine::create()->renderString($template, \SilverStripe\View\ViewLayerData::create($record->customise(['Foo' => 'Bar'])));
        $exists = \SilverStripe\TemplateEngine\SSTemplateEngine::create()->hasTemplate(['Page']);
    }
}

