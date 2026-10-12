<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Control\CliBypass;
use SilverStripe\Control\SessionEnvTypeSwitcher;
use SilverStripe\ContentReview\Tasks\ContentReviewOwnerMigrationTask;
use SilverStripe\ORM\Tasks\ConvertTranslatableTask;
use SilverStripe\SolrSearch\Tasks\SolrIndexCheck;
use SilverStripe\UserForms\Tasks\UserFormsColumnCleanTask;

final class DeprecatedCliBypass extends CliBypass
{
}

final class DeprecatedContentReviewOwnerMigrationTask extends ContentReviewOwnerMigrationTask
{
}

final class DeprecatedConvertTranslatableTask extends ConvertTranslatableTask
{
}

final class DeprecatedUserFormsColumnCleanTask extends UserFormsColumnCleanTask
{
}

final class DeprecatedSolrIndexCheck extends SolrIndexCheck
{
}

final class DeprecatedSessionEnvTypeSwitcher extends SessionEnvTypeSwitcher
{
}

-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Control\CliBypass;
use SilverStripe\Control\SessionEnvTypeSwitcher;
use SilverStripe\ContentReview\Tasks\ContentReviewOwnerMigrationTask;
use SilverStripe\ORM\Tasks\ConvertTranslatableTask;
use SilverStripe\SolrSearch\Tasks\SolrIndexCheck;
use SilverStripe\UserForms\Tasks\UserFormsColumnCleanTask;

/**
 * @deprecated CliBypass has been deprecated. It will be removed without equivalent functionality to replace it.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
final class DeprecatedCliBypass extends CliBypass
{
}

/**
 * @deprecated ContentReviewOwnerMigrationTask has been deprecated. It will be removed without equivalent functionality to replace it.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
final class DeprecatedContentReviewOwnerMigrationTask extends ContentReviewOwnerMigrationTask
{
}

/**
 * @deprecated ConvertTranslatableTask has been deprecated. It will be removed without equivalent functionality to replace it.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
final class DeprecatedConvertTranslatableTask extends ConvertTranslatableTask
{
}

/**
 * @deprecated UserFormsColumnCleanTask has been deprecated. It will be removed without equivalent functionality to replace it.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
final class DeprecatedUserFormsColumnCleanTask extends UserFormsColumnCleanTask
{
}

/**
 * @deprecated SolrIndexCheck has been deprecated. It will be removed without equivalent functionality to replace it.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
final class DeprecatedSolrIndexCheck extends SolrIndexCheck
{
}

/**
 * @deprecated SessionEnvTypeSwitcher has been deprecated. It will be removed without equivalent functionality to replace it.
 * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
 */
final class DeprecatedSessionEnvTypeSwitcher extends SessionEnvTypeSwitcher
{
}
