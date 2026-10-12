<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\ContentReview\Tasks\ContentReviewEmails;

class ContentReviewEmailTest
{
    public function test(ContentReviewEmails $emails, ?string $email): bool
    {
        return $emails->isValidEmail($email);
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Control\Email\Email;
use SilverStripe\ContentReview\Tasks\ContentReviewEmails;

class ContentReviewEmailTest
{
    public function test(ContentReviewEmails $emails, ?string $email): bool
    {
        return Email::is_valid_address($email);
    }
}
?>
