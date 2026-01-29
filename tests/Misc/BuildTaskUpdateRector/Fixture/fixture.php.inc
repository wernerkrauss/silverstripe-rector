<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\BuildTaskUpdateRector\Fixture;

use SilverStripe\Dev\BuildTask;

class MyTask extends BuildTask
{
    protected $title = 'My Task';

    public function run($request)
    {
        echo "Running task";
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\BuildTaskUpdateRector\Fixture;

use SilverStripe\Dev\BuildTask;

class MyTask extends BuildTask
{
    protected string $title = 'My Task';

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \SilverStripe\PolyExecution\PolyOutput $output): int
    {
        $output->writeln('Running task');
        return \Symfony\Component\Console\Command\Command::SUCCESS;
    }
}

?>
