<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\BuildTaskUpdateRector\Fixture;

use SilverStripe\Dev\BuildTask;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExistingExecuteTask extends BuildTask
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Already migrated');
        return 0;
    }
}
