<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe413\Fixture;

use SilverStripe\ORM\DataList;

class MyListUsage
{
    public function useGenerator(DataList $list)
    {
        return $list->getGenerator();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe413\Fixture;

use SilverStripe\ORM\DataList;

class MyListUsage
{
    public function useGenerator(DataList $list)
    {
        /**
         * @deprecated DataList::getGenerator() has been deprecated. It will be removed without equivalent functionality to replace it.
         * See: https://docs.silverstripe.org/en/4/changelogs/4.13.0/#api-deprecated
         */
        return $list->getGenerator();
    }
}
?>
