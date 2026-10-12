<?php

use SilverStripe\CMS\Controllers\CMSMain;

$cmsMain = new CMSMain();
$cmsMain->PageListSidebar();
?>
-----
<?php

use SilverStripe\CMS\Controllers\CMSMain;

$cmsMain = new CMSMain();
/**
 * @deprecated CMSMain::PageListSidebar() has been deprecated. It will be removed without equivalent functionality to replace it.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
$cmsMain->PageListSidebar();
?>
