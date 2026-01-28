<?php

namespace Netwerkstatt\SilverstripeRector\Tests\PHPStan\Rules\Rector\Fixture;

use Rector\Rector\AbstractRector;
use PhpParser\Node;

class MissingInterfaceRector extends AbstractRector
{
    public function getNodeTypes(): array
    {
        return [];
    }

    public function refactor(Node $node): ?Node
    {
        return null;
    }
}
