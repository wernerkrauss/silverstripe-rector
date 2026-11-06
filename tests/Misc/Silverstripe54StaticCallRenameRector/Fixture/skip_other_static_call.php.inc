<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\Silverstripe54StaticCallRenameRector\Fixture;

use SilverStripe\View\SSViewer;

final class OtherStaticCall
{
    public function test(): void
    {
        SSViewer::getTemplate();
    }
}
