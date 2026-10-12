<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Logging\HTTPOutputHandler;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\View\ArrayData;

final class FrameworkClassRenames
{
    public function test(): void
    {
        $list = new ArrayList();
        $result = new ValidationResult();
        $data = new ArrayData([]);
        $handler = new HTTPOutputHandler();
    }
}
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Model\List\ArrayList;
use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Model\ArrayData;
use SilverStripe\Logging\ErrorOutputHandler;

final class FrameworkClassRenames
{
    public function test(): void
    {
        $list = new ArrayList();
        $result = new ValidationResult();
        $data = new ArrayData([]);
        $handler = new ErrorOutputHandler();
    }
}
