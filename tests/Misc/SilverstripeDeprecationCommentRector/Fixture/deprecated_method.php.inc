<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Fixture;

use Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Source\ClassWithDeprecatedMethod;

class SomeOtherClass extends ClassWithDeprecatedMethod
{
    public function deprecatedMethod()
    {
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Fixture;

use Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Source\ClassWithDeprecatedMethod;

class SomeOtherClass extends ClassWithDeprecatedMethod
{
    /**
     * @deprecated This method is deprecated.
     * See: https://docs.silverstripe.org/deprecated-method
     */
    public function deprecatedMethod()
    {
    }
}
?>
