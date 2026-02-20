<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\Dev\Constraint\ViewableDataContains;
use SilverStripe\Dev\Validation\DatabaseAdminExtension;

class DevRenames
{
    public function run(ViewableDataContains $viewableDataContains, DatabaseAdminExtension $databaseAdminExtension)
    {
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\Dev\Constraint\ModelDataContains;
use SilverStripe\Dev\Validation\DbBuildExtension;

class DevRenames
{
    public function run(ModelDataContains $viewableDataContains, DbBuildExtension $databaseAdminExtension)
    {
    }
}
?>
