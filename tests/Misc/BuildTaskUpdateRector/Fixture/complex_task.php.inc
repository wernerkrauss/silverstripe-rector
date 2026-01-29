<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\BuildTaskUpdateRector\Fixture;

use SilverStripe\Dev\BuildTask;
use SilverStripe\Control\HTTPRequest;

class MyCustomTask extends BuildTask
{
    private static $segment = 'my-custom-task';

    protected $title = 'My custom task';

    protected $description = 'A task that does something custom';

    public function run(HTTPRequest $request)
    {
        if ($request->getVar('do-action')) {
            echo "Doing something...\n";
        }
        echo "Done\n";
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\BuildTaskUpdateRector\Fixture;

use SilverStripe\Dev\BuildTask;
use SilverStripe\Control\HTTPRequest;

class MyCustomTask extends BuildTask
{
    protected static string $commandName = 'my-custom-task';

    protected string $title = 'My custom task';

    protected static string $description = 'A task that does something custom';

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \SilverStripe\PolyExecution\PolyOutput $output): int
    {
        if ($input->getOption('do-action')) {
            $output->writeln('Doing something...');
        }
        $output->writeln('Done');
        return \Symfony\Component\Console\Command\Command::SUCCESS;
    }
    public function getOptions(): array
    {
        return [new \Symfony\Component\Console\Input\InputOption('do-action', null, \Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'do something specific')];
    }
}
?>
