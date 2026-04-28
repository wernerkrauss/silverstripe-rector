<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RemoveSilverstripeDeprecationCommentRector\Fixture;

use SilverStripe\Control\Director;

/**
 * @deprecated Director is deprecated.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
class MyDirector extends Director
{
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\RemoveSilverstripeDeprecationCommentRector\Fixture;

use SilverStripe\Control\Director;

class MyDirector extends Director
{
}
?>
