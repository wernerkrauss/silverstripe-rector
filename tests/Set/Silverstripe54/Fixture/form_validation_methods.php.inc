<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormField;
use SilverStripe\Forms\TextareaField;

final class FormValidationMethods
{
    public function test(Form $form, FormField $field, TextareaField $textarea): void
    {
        $form->validationResult();
        $field->extendValidationResult();
        $textarea->ValueEntities();
    }
}

-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormField;
use SilverStripe\Forms\TextareaField;

final class FormValidationMethods
{
    public function test(Form $form, FormField $field, TextareaField $textarea): void
    {
        /**
         * @deprecated Form::validationResult() has been deprecated. Use Form::validate() instead.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $form->validate();
        /**
         * @deprecated FormField::extendValidationResult() has been deprecated. Use extend() directly instead.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $field->extend();
        /**
         * @deprecated TextareaField::ValueEntities() has been deprecated. Use getFormattedValueEntities() instead.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $textarea->getFormattedValueEntities();
    }
}
