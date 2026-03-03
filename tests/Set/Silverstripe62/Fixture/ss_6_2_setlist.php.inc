<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe62;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataList;

class Silverstripe62SetList
{
    public function fieldList(FieldList $fields)
    {
        $dataFields = $fields->dataFields();
    }

    public function getIDList(DataList $list)
    {
        $ids = $list->getIDList();
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe62;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataList;

class Silverstripe62SetList
{
    public function fieldList(FieldList $fields)
    {
        $dataFields = $fields->getDataFields();
    }

    public function getIDList(DataList $list)
    {
        $ids = $list->sort(null)->column('ID');
    }
}
?>
