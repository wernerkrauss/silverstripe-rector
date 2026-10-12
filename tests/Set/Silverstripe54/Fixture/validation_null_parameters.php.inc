<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\Form;

final class ValidationNullParameters
{
    public function test(ValidationResult $result, Form $form): void
    {
        $result->addError('Message', 'bad', null, null);
        $result->addFieldError('Field', 'Message', 'bad', null, null);
        $result->addMessage('Message', 'bad', null, null);
        $result->addFieldMessage('Field', 'Message', 'bad', null, null);
        $form->sessionMessage('Message', 'bad', null);
        $form->sessionError('Message', 'bad', null);
        $form->sessionFieldError('Message', 'Field', 'bad', null);
        $result->addError('Message', 'bad', 'code', ValidationResult::CAST_TEXT);
        $result->addFieldError('Field', 'Message', 'bad', 'code', ValidationResult::CAST_TEXT);
        $result->addMessage('Message', 'bad', 'code', ValidationResult::CAST_TEXT);
        $result->addFieldMessage('Field', 'Message', 'bad', 'code', ValidationResult::CAST_TEXT);
        $form->sessionMessage('Message', 'bad', ValidationResult::CAST_TEXT);
        $form->sessionError('Message', 'bad', ValidationResult::CAST_TEXT);
        $form->sessionFieldError('Message', 'Field', 'bad', ValidationResult::CAST_TEXT);
    }
}

-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\Form;

final class ValidationNullParameters
{
    public function test(ValidationResult $result, Form $form): void
    {
        /**
         * @deprecated Passing null for the $code or $cast parameter in ValidationResult::addError() is deprecated.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $result->addError('Message', 'bad', null, null);
        /**
         * @deprecated Passing null for the $code or $cast parameter in ValidationResult::addFieldError() is deprecated.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $result->addFieldError('Field', 'Message', 'bad', null, null);
        /**
         * @deprecated Passing null for the $code or $cast parameter in ValidationResult::addMessage() is deprecated.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $result->addMessage('Message', 'bad', null, null);
        /**
         * @deprecated Passing null for the $code or $cast parameter in ValidationResult::addFieldMessage() is deprecated.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $result->addFieldMessage('Field', 'Message', 'bad', null, null);
        /**
         * @deprecated Passing null for the $cast parameter in Form::sessionMessage() is deprecated.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $form->sessionMessage('Message', 'bad', null);
        /**
         * @deprecated Passing null for the $cast parameter in Form::sessionError() is deprecated.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $form->sessionError('Message', 'bad', null);
        /**
         * @deprecated Passing null for the $cast parameter in Form::sessionFieldError() is deprecated.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $form->sessionFieldError('Message', 'Field', 'bad', null);
        $result->addError('Message', 'bad', 'code', ValidationResult::CAST_TEXT);
        $result->addFieldError('Field', 'Message', 'bad', 'code', ValidationResult::CAST_TEXT);
        $result->addMessage('Message', 'bad', 'code', ValidationResult::CAST_TEXT);
        $result->addFieldMessage('Field', 'Message', 'bad', 'code', ValidationResult::CAST_TEXT);
        $form->sessionMessage('Message', 'bad', ValidationResult::CAST_TEXT);
        $form->sessionError('Message', 'bad', ValidationResult::CAST_TEXT);
        $form->sessionFieldError('Message', 'Field', 'bad', ValidationResult::CAST_TEXT);
    }
}
