<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\Validation\FieldsValidator;

final class DeprecatedFieldsValidator extends FieldsValidator
{
}

-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\Validation\FieldsValidator;

/**
 * @deprecated FieldsValidator has been deprecated. It will be replaced with functionality inside Form::validate().
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
final class DeprecatedFieldsValidator extends FieldsValidator
{
}
