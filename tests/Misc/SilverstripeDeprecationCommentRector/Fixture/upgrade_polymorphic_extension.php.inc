<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Fixture;

use Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Source\UserForms\Extension\UpgradePolymorphicExtension;

class MyUserFormsExtension extends UpgradePolymorphicExtension
{
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Fixture;

use Netwerkstatt\SilverstripeRector\Tests\Misc\SilverstripeDeprecationCommentRector\Source\UserForms\Extension\UpgradePolymorphicExtension;

/**
 * @deprecated UpgradePolymorphicExtension has been deprecated and will be removed without equivalent functionality
 * See: https://docs.silverstripe.org/en/6/changelogs/6.1.0/#api-changes
 */
class MyUserFormsExtension extends UpgradePolymorphicExtension
{
}
?>
