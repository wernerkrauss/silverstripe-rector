<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\Silverstripe54StaticCallRenameRector\Fixture;

use SilverStripe\ORM\FieldType\DBEnum;
use SilverStripe\View\SSViewer;

final class StaticCalls
{
    public function test(): void
    {
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
        \SilverStripe\ORM\FieldType\DBEnum::reset();
    }
}
