<?php

use SilverStripe\CMS\Model\SiteTree;

class Page extends SiteTree
{
    public static bool $need_permission = true;
}

$value = SiteTree::$need_permission;
SiteTree::$need_permission = false;
$subclassValue = Page::$need_permission;
?>
-----
<?php

use SilverStripe\CMS\Model\SiteTree;

class Page extends SiteTree
{
    public static bool $need_permission = true;
}

/**
 * @deprecated The SiteTree.need_permission configuration property has been deprecated. Use SiteTree::canCreate() instead.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
$value = SiteTree::$need_permission;
/**
 * @deprecated The SiteTree.need_permission configuration property has been deprecated. Use SiteTree::canCreate() instead.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
SiteTree::$need_permission = false;
/**
 * @deprecated The SiteTree.need_permission configuration property has been deprecated. Use SiteTree::canCreate() instead.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
$subclassValue = Page::$need_permission;
?>
