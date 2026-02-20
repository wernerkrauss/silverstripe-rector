<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\Core\Extension;

class MemberExtensionRename extends Extension
{
    public function afterMemberLoggedIn()
    {
    }

    public function afterMemberLoggedOut()
    {
    }

    public function authenticationFailed()
    {
    }

    public function authenticationFailedUnknownUser()
    {
    }

    public function authenticationSucceeded()
    {
    }

    public function beforeMemberLoggedIn()
    {
    }

    public function beforeMemberLoggedOut()
    {
    }

    public function registerFailedLogin()
    {
    }

    public function init()
    {
    }

    public function flushCache()
    {
    }

    public function populateDefaults()
    {
    }

    public function requireDefaultRecords()
    {
    }

    public function forgotPassword()
    {
    }

    public function getDefaultRecords()
    {
    }

    public function MetaComponents()
    {
    }

    public function MetaTags()
    {
    }

    public function validate()
    {
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe60\Fixture;

use SilverStripe\Core\Extension;

class MemberExtensionRename extends Extension
{
    public function onAfterMemberLoggedIn()
    {
    }

    public function onAfterMemberLoggedOut()
    {
    }

    public function onAuthenticationFailed()
    {
    }

    public function onAuthenticationFailedUnknownUser()
    {
    }

    public function onAuthenticationSucceeded()
    {
    }

    public function onBeforeMemberLoggedIn()
    {
    }

    public function onBeforeMemberLoggedOut()
    {
    }

    public function onRegisterFailedLogin()
    {
    }

    public function onInit()
    {
    }

    public function onFlushCache()
    {
    }

    public function onAfterPopulateDefaults()
    {
    }

    public function onRequireDefaultRecords()
    {
    }

    public function onForgotPassword()
    {
    }

    public function updateDefaultRecords()
    {
    }

    public function updateMetaComponents()
    {
    }

    public function updateMetaTags()
    {
    }

    public function updateValidate()
    {
    }
}
?>
