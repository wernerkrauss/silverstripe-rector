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
    protected $description = 'My Task';

    public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        echo "Running task";
    }
}

?>
