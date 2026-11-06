<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Forms\Silverstripe54MethodCallToStaticCallRector\Fixture;

use SilverStripe\ContentReview\Tasks\ContentReviewEmails;
use SilverStripe\Logging\ErrorOutputHandler;

final class DeprecatedCalls
{
    public function test(ContentReviewEmails $emails, ErrorOutputHandler $handler, ?string $email): void
    {
        $emails->isValidEmail($email);
        $handler->isCli();
    }
}

-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Forms\Silverstripe54MethodCallToStaticCallRector\Fixture;

use SilverStripe\ContentReview\Tasks\ContentReviewEmails;
use SilverStripe\Logging\ErrorOutputHandler;

final class DeprecatedCalls
{
    public function test(ContentReviewEmails $emails, ErrorOutputHandler $handler, ?string $email): void
    {
        \SilverStripe\Control\Email\Email::is_valid_address($email);
        \SilverStripe\Control\Director::is_cli();
    }
}
