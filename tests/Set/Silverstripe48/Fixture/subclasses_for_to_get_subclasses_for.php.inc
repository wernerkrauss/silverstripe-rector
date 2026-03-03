<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe48\Fixture;

use SilverStripe\Core\ClassInfo;

class subclasses_for_to_get_subclasses_for
{
    public function someMethod()
    {
        $subclasses = ClassInfo::subclassesFor('SomeClass');
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe48\Fixture;

use SilverStripe\Core\ClassInfo;

class subclasses_for_to_get_subclasses_for
{
    public function someMethod()
    {
        $subclasses = ClassInfo::getSubclassesFor('SomeClass');
    }
}
?>
