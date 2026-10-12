<?php

use SilverStripe\CMS\Controllers\CMSPageAddController;
use SilverStripe\CMS\Controllers\CMSPagesController;

class AddController extends CMSPageAddController
{
}

class PagesController extends CMSPagesController
{
}
?>
-----
<?php

use SilverStripe\CMS\Controllers\CMSPageAddController;
use SilverStripe\CMS\Controllers\CMSPagesController;

/**
 * @deprecated CMSPageAddController has been deprecated. It will be replaced with SilverStripe\CMS\Forms\CMSMainAddForm.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
class AddController extends CMSPageAddController
{
}

/**
 * @deprecated CMSPagesController has been deprecated. It will be combined back into CMSMain.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
class PagesController extends CMSPagesController
{
}
?>
