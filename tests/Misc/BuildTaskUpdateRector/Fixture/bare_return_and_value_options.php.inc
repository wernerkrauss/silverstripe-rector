<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\BuildTaskUpdateRector\Fixture;

use SilverStripe\Dev\BuildTask;

class BareReturnTask extends BuildTask
{
    public function run($request)
    {
        if (!$request->getVar('run')) {
            echo "Add ?run=1 to run this task";
            return;
        }
        $limit = (int) $request->getVar('limit');
        $query = $request->getVar('query');
        $items = array_map(function ($item) use ($request) {
            if ($request->getVar('dry-run')) {
                echo "Processing item";
            }
            return;
        }, []);
        if ($query) {
            return;
        }
        echo "Done";
        return;
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\BuildTaskUpdateRector\Fixture;

use SilverStripe\Dev\BuildTask;

class BareReturnTask extends BuildTask
{
    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \SilverStripe\PolyExecution\PolyOutput $output): int
    {
        if (!$input->getOption('run')) {
            $output->writeln('Add ?run=1 to run this task');
            return \Symfony\Component\Console\Command\Command::SUCCESS;
        }
        $limit = (int) $input->getOption('limit');
        $query = $input->getOption('query');
        $items = array_map(function ($item) use ($request) {
            if ($input->getOption('dry-run')) {
                $output->writeln('Processing item');
            }
            return;
        }, []);
        if ($query) {
            return \Symfony\Component\Console\Command\Command::SUCCESS;
        }
        $output->writeln('Done');
        return \Symfony\Component\Console\Command\Command::SUCCESS;
    }
    public function getOptions(): array
    {
        return [new \Symfony\Component\Console\Input\InputOption('run', null, \Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'do something specific'), new \Symfony\Component\Console\Input\InputOption('limit', null, \Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL, 'do something specific'), new \Symfony\Component\Console\Input\InputOption('query', null, \Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL, 'do something specific'), new \Symfony\Component\Console\Input\InputOption('dry-run', null, \Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'do something specific')];
    }
}
?>
