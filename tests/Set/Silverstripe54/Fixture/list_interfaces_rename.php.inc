<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

final class ListInterfacesRename
{
    public function isFilterable(mixed $list): bool
    {
        return $list instanceof \SilverStripe\ORM\Filterable;
    }

    public function limit(\SilverStripe\ORM\Limitable $list, int $length): \SilverStripe\ORM\Limitable
    {
        return $list;
    }

    public function sort(\SilverStripe\ORM\Sortable $list): \SilverStripe\ORM\Sortable
    {
        return $list;
    }
}
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Model\List\SS_List;

final class ListInterfacesRename
{
    public function isFilterable(mixed $list): bool
    {
        return $list instanceof SS_List;
    }

    public function limit(SS_List $list, int $length): SS_List
    {
        return $list;
    }

    public function sort(SS_List $list): SS_List
    {
        return $list;
    }
}
