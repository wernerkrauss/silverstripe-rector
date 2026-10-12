<?php

use SilverStripe\Admin\LeftAndMain;

$controller = new LeftAndMain();
$controller->methodSchema();
?>
-----
<?php

use SilverStripe\Admin\LeftAndMain;

$controller = new LeftAndMain();
/**
 * @deprecated LeftAndMain::methodSchema() has been deprecated. It will be replaced with FormSchemaController::schema().
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
$controller->methodSchema();
?>
