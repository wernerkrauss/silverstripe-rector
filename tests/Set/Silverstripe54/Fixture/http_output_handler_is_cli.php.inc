<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Logging\HTTPOutputHandler;

final class HttpOutputHandlerIsCli
{
    public function test(HTTPOutputHandler $handler): bool
    {
        $handler = new HTTPOutputHandler();
        if ($handler->isCli()) {
            $handler->write('Running in CLI mode');
        }

        return $handler->isCli();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Logging\ErrorOutputHandler;
use SilverStripe\Control\Director;

final class HttpOutputHandlerIsCli
{
    public function test(ErrorOutputHandler $handler): bool
    {
        $handler = new ErrorOutputHandler();
        if (Director::is_cli()) {
            $handler->write('Running in CLI mode');
        }

        return Director::is_cli();
    }
}
?>
