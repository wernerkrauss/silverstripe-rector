<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\ReplaceSilverstripeNullArgumentRector\Fixture;

use SilverStripe\Core\Validation\ValidationResult;

final class SkipOtherValues
{
    public function test(ValidationResult $result): void
    {
        $result->addError('Message', 'bad', 'code');
        $result->addError('Message', 'bad', '');
        $result->addError('Message', 'bad', ValidationResult::CAST_TEXT);
    }
}
