<?php

use SilverStripe\Forms\FormField;

$field = new FormField();
$field->validate(new stdClass());
?>
-----
<?php

use SilverStripe\Forms\FormField;

$field = new FormField();
/**
 * @deprecated FormField::validate() will take zero arguments and return a ValidationResult object instead of a boolean in CMS 6.0.0.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
$field->validate(new stdClass());
?>
