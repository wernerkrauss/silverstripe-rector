<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\BuildTaskUpdateRector\Fixture;

use SilverStripe\Dev\BuildTask;

class NoParamTask extends BuildTask
{
    public function run()
    {
        echo "Running task";
    }
}
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\BuildTaskUpdateRector\Fixture;

use SilverStripe\Dev\BuildTask;

class NoParamTask extends BuildTask
{
    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \SilverStripe\PolyExecution\PolyOutput $output): int
    {
        $output->writeln('Running task');
        return \Symfony\Component\Console\Command\Command::SUCCESS;
    }
}
