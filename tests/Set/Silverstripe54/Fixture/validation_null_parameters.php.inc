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
        $result->addError('Message', 'bad', '', ValidationResult::CAST_TEXT);
        $result->addFieldError('Field', 'Message', 'bad', '', ValidationResult::CAST_TEXT);
        $result->addMessage('Message', 'bad', '', ValidationResult::CAST_TEXT);
        $result->addFieldMessage('Field', 'Message', 'bad', '', ValidationResult::CAST_TEXT);
        $form->sessionMessage('Message', 'bad', ValidationResult::CAST_TEXT);
        $form->sessionError('Message', 'bad', ValidationResult::CAST_TEXT);
        $form->sessionFieldError('Message', 'Field', 'bad', ValidationResult::CAST_TEXT);
        $result->addError('Message', 'bad', 'code', ValidationResult::CAST_TEXT);
        $result->addFieldError('Field', 'Message', 'bad', 'code', ValidationResult::CAST_TEXT);
        $result->addMessage('Message', 'bad', 'code', ValidationResult::CAST_TEXT);
        $result->addFieldMessage('Field', 'Message', 'bad', 'code', ValidationResult::CAST_TEXT);
        $form->sessionMessage('Message', 'bad', ValidationResult::CAST_TEXT);
        $form->sessionError('Message', 'bad', ValidationResult::CAST_TEXT);
        $form->sessionFieldError('Message', 'Field', 'bad', ValidationResult::CAST_TEXT);
    }
}
