<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Logging\HTTPOutputHandler;

final class CustomOutputHandler extends HTTPOutputHandler
{
}

final class HttpOutputHandlerSubclassIsCli
{
    public function test(): bool
    {
        $handler = new CustomOutputHandler();

        return $handler->isCli();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Logging\ErrorOutputHandler;
use SilverStripe\Control\Director;

final class CustomOutputHandler extends ErrorOutputHandler
{
}

final class HttpOutputHandlerSubclassIsCli
{
    public function test(): bool
    {
        $handler = new CustomOutputHandler();

        return Director::is_cli();
    }
}
?>
