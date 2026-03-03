<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Rector\ORM\GetIDListToColumnIDRector\Fixture;

class SomeOtherClass
{
    public function getIDList()
    {
        return [];
    }
}

function skipOtherClasses(SomeOtherClass $list)
{
    return $list->getIDList();
}
?>
