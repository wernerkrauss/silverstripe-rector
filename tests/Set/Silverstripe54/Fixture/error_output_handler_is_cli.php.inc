<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Logging\ErrorOutputHandler;

final class ErrorOutputHandlerIsCli
{
    public function test(ErrorOutputHandler $handler): bool
    {
        return $handler->isCli();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Control\Director;
use SilverStripe\Logging\ErrorOutputHandler;

final class ErrorOutputHandlerIsCli
{
    public function test(ErrorOutputHandler $handler): bool
    {
        return Director::is_cli();
    }
}
?>
