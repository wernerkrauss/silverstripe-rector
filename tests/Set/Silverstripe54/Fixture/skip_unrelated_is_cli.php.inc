<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Control\Director;

final class UnrelatedService
{
    public function isCli(): bool
    {
        return true;
    }
}

final class SkipUnrelatedIsCli
{
    public function test(UnrelatedService $service): bool
    {
        $isCli = $service->isCli();
        $isDirectorCli = Director::is_cli();

        return $isCli && $isDirectorCli;
    }
}
