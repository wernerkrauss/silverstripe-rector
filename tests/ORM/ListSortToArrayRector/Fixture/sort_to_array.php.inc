<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\ListSortToArrayRector\Fixture;

use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;

class MyDataObject extends DataObject
{
}

function sortTest()
{
    /** @var DataList $list */
    $list = MyDataObject::get();

    // Two arguments
    $list->sort('Title', 'DESC');
    $list->sort('Created', 'ASC');

    // One argument
    $list->sort('Title');
    $list->sort('Title ASC');
    $list->sort('Title DESC');

    // Multiple fields in one string
    $list->sort('Sort ASC, Title ASC');
    $list->sort('Created DESC, ID ASC');
    $list->sort('Field1, Field2 DESC');

    // Already an array
    $list->sort(['Title' => 'ASC']);

    // Complex SQL - should be skipped
    $list->sort('RAND()');
    $list->sort('IF(ID > 10, 1, 0) DESC');
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\ORM\ListSortToArrayRector\Fixture;

use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;

class MyDataObject extends DataObject
{
}

function sortTest()
{
    /** @var DataList $list */
    $list = MyDataObject::get();

    // Two arguments
    $list->sort(['Title' => 'DESC']);
    $list->sort(['Created' => 'ASC']);

    // One argument
    $list->sort(['Title' => 'ASC']);
    $list->sort(['Title' => 'ASC']);
    $list->sort(['Title' => 'DESC']);

    // Multiple fields in one string
    $list->sort(['Sort' => 'ASC', 'Title' => 'ASC']);
    $list->sort(['Created' => 'DESC', 'ID' => 'ASC']);
    $list->sort(['Field1' => 'ASC', 'Field2' => 'DESC']);

    // Already an array
    $list->sort(['Title' => 'ASC']);

    // Complex SQL - should be skipped
    $list->sort('RAND()');
    $list->sort('IF(ID > 10, 1, 0) DESC');
}
?>
