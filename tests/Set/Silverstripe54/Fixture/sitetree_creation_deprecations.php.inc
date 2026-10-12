<?php

use SilverStripe\CMS\Model\SiteTree;

class ArticlePage extends SiteTree
{
}

ArticlePage::page_type_classes();
ArticlePage::setCreatableChildrenCache(new stdClass());
ArticlePage::getCreatableChildrenCache();
?>
-----
<?php

use SilverStripe\CMS\Model\SiteTree;

class ArticlePage extends SiteTree
{
}

/**
 * @deprecated SiteTree::page_type_classes() has been deprecated. It will be replaced with updateAllowedSubClasses().
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
ArticlePage::page_type_classes();
/**
 * @deprecated SiteTree::setCreatableChildrenCache() has been deprecated. It will be replaced with CMSMain::setCreatableChildrenCache().
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
ArticlePage::setCreatableChildrenCache(new stdClass());
/**
 * @deprecated SiteTree::getCreatableChildrenCache() has been deprecated. It will be replaced with CMSMain::getCreatableChildrenCache().
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
ArticlePage::getCreatableChildrenCache();
?>
