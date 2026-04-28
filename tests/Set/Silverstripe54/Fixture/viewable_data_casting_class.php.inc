<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\View\ViewableData;

class MyViewable extends ViewableData
{
    public function useCasting()
    {
        return $this->castingClass('MyField');
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\View\ViewableData;

class MyViewable extends ViewableData
{
    public function useCasting()
    {
        /**
         * @deprecated ViewableData::castingClass() has been deprecated. It will be removed without equivalent functionality to replace it.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        return $this->castingClass('MyField');
    }
}
?>
