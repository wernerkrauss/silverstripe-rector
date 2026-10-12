<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\ReplaceSilverstripeNullArgumentRector\Fixture;

use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\Form;

final class NullArguments
{
    public function test(ValidationResult $result, Form $form): void
    {
        $result->addError('Message', 'bad', null);
        $form->sessionMessage('Message', 'bad', null);
    }
}

-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\ReplaceSilverstripeNullArgumentRector\Fixture;

use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\Form;

final class NullArguments
{
    public function test(ValidationResult $result, Form $form): void
    {
        $result->addError('Message', 'bad', '');
        $form->sessionMessage('Message', 'bad', ValidationResult::CAST_TEXT);
    }
}
