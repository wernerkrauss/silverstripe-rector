<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\BuildTaskUpdateRector\Fixture;

use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DB;

class MyTask extends BuildTask
{
    protected $title = 'My Task';

    public function run($request)
    {
        DB::alteration_message("Success message", "created");
        DB::alteration_message("Error message", "error");
        DB::alteration_message("Info without type");
    }
}

?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\BuildTaskUpdateRector\Fixture;

use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DB;

class MyTask extends BuildTask
{
    protected string $title = 'My Task';

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \SilverStripe\PolyExecution\PolyOutput $output): int
    {
        $output->writeln("<info>Success message</info>");
        $output->writeln("<error>Error message</error>");
        $output->writeln("Info without type");
        return \Symfony\Component\Console\Command\Command::SUCCESS;
    }
}

?>
