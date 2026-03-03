<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe413\Fixture;

use SilverStripe\CMS\Tasks\RemoveOrphanedPagesTask;

class MyTask extends RemoveOrphanedPagesTask
{
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe413\Fixture;

use SilverStripe\CMS\Tasks\RemoveOrphanedPagesTask;

/**
 * @deprecated RemoveOrphanedPagesTask has been deprecated. It will be removed without equivalent functionality to replace it.
 * See: https://docs.silverstripe.org/en/4/changelogs/4.13.0/#api-deprecated
 */
class MyTask extends RemoveOrphanedPagesTask
{
}
?>
