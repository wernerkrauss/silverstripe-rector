<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54To60\Fixture;

final class UpgradePathListInterfaces
{
    public function isSortable(mixed $list): bool
    {
        return $list instanceof \SilverStripe\ORM\Sortable;
    }

    public function filter(\SilverStripe\ORM\Filterable $list): \SilverStripe\ORM\Filterable
    {
        return $list;
    }

    public function limit(\SilverStripe\ORM\Limitable $list, int $length): \SilverStripe\ORM\Limitable
    {
        return $list;
    }
}
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54To60\Fixture;

use SilverStripe\Model\List\SS_List;

final class UpgradePathListInterfaces
{
    public function isSortable(mixed $list): bool
    {
        return $list instanceof SS_List;
    }

    public function filter(SS_List $list): SS_List
    {
        return $list;
    }

    public function limit(SS_List $list, int $length): SS_List
    {
        return $list;
    }
}
