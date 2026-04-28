<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\GridField\GridFieldDataColumns;

class GetValueFromRelationTest
{
    public function test(GridFieldDataColumns $columns)
    {
        $columns->getValueFromRelation('test', 'test');
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\GridField\GridFieldDataColumns;

class GetValueFromRelationTest
{
    public function test(GridFieldDataColumns $columns)
    {
        /**
         * @deprecated GridFieldDataColumns::getValueFromRelation() has been deprecated. It will be removed without equivalent functionality to replace it.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $columns->getValueFromRelation('test', 'test');
    }
}
?>
