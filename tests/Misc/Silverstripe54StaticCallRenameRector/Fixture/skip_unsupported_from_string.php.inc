<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\Silverstripe54StaticCallRenameRector\Fixture;

use SilverStripe\View\SSViewer;

final class SkipUnsupportedFromString
{
    public function test($record, string $template): void
    {
        // No model available: must not become a static renderString() call
        $viewer = SSViewer::fromString($template);
        // Extra arguments are not mapped
        $html = $record->renderWith(SSViewer::fromString($template, false));
        $html = $record->renderWith(SSViewer::fromString($template), ['Foo' => 'Bar']);
    }
}
