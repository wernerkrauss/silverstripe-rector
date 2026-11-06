<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\Silverstripe54StaticCallRenameRector\Fixture;

use SilverStripe\ORM\FieldType\DBEnum;
use SilverStripe\View\SSViewer;

final class StaticCalls
{
    public function test(): void
    {
        SSViewer::fromString('template');
        DBEnum::flushCache();
    }
}

-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\Silverstripe54StaticCallRenameRector\Fixture;

use SilverStripe\ORM\FieldType\DBEnum;
use SilverStripe\View\SSViewer;

final class StaticCalls
{
    public function test(): void
    {
        \SilverStripe\TemplateEngine\SSTemplateEngine::renderString('template');
        \SilverStripe\ORM\FieldType\DBEnum::reset();
    }
}
