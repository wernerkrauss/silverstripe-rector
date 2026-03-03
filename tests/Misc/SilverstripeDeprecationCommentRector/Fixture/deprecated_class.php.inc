<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Fixture;

use Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Source\DeprecatedClass;

class SomeClass extends DeprecatedClass
{
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Fixture;

use Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Source\DeprecatedClass;

/**
 * @deprecated This class is deprecated.
 * See: https://docs.silverstripe.org/deprecated-class
 */
class SomeClass extends DeprecatedClass
{
}
?>
