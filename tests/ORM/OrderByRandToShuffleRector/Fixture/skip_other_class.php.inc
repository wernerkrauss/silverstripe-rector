<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\OrderByRandToShuffleRector\Fixture;

class SkipOtherList
{
    public function orderBy($sort)
    {
        return $sort;
    }
}

class SkipOtherClass
{
    public function bar(SkipOtherList $list)
    {
        return $list->orderBy('RAND()');
    }
}

?>
