<?php

use SilverStripe\CMS\Controllers\CMSMain;

$cmsMain = new CMSMain();
$cmsMain->LinkPreview();
$cmsMain->getSearchContext();
$cmsMain->performPublish();
?>
-----
<?php

use SilverStripe\CMS\Controllers\CMSMain;

$cmsMain = new CMSMain();
/**
 * @deprecated CMSMain::LinkPreview() has been deprecated. Use SiteTree::CMSEditLink() instead.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
$cmsMain->LinkPreview();
/**
 * @deprecated CMSMain::getSearchContext() has been deprecated. It will be replaced with SiteTree::getDefaultSearchContext().
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
$cmsMain->getSearchContext();
/**
 * @deprecated CMSMain::performPublish() has been deprecated. Use RecursivePublishable::publishRecursive() instead.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
$cmsMain->performPublish();
?>
