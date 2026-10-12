<?php

use SilverStripe\CMS\Model\SiteTree;

$siteTree = new SiteTree();
$siteTree->getPermissionChecker();
$siteTree->flushMemberCache();
$siteTree->creatableChildPages();
$siteTree->getIconClass();
$siteTree->getPageIconURL();
SiteTree::generateChildrenCacheKey();

?>
-----
<?php

use SilverStripe\CMS\Model\SiteTree;

$siteTree = new SiteTree();
/**
 * @deprecated SiteTree::getPermissionChecker() has been deprecated. It will be replaced with a non-static method of the same name.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
$siteTree->getPermissionChecker();
/**
 * @deprecated SiteTree::flushMemberCache() has been deprecated. It will be replaced with CMSMain::clearCache().
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
$siteTree->flushMemberCache();
/**
 * @deprecated SiteTree::creatableChildPages() has been deprecated. It will be replaced with CMSMain::getCreatableSubClasses().
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
$siteTree->creatableChildPages();
/**
 * @deprecated SiteTree::getIconClass() has been deprecated. It will be replaced with CMSMain::getRecordIconCssClass().
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
$siteTree->getIconClass();
/**
 * @deprecated SiteTree::getPageIconURL() has been deprecated. It will be replaced with CMSMain::getRecordIconUrl().
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
$siteTree->getPageIconURL();
/**
 * @deprecated SiteTree::generateChildrenCacheKey() has been deprecated. It will be replaced with CMSMain::generateChildrenCacheKey().
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
SiteTree::generateChildrenCacheKey();

?>
