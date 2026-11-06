<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceSuperglobalRequestAccessRector\Fixture;

class SkipNoRequestContext
{
    public function handle()
    {
        return $_GET['foo'];
    }
}

?>
