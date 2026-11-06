<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\PHPStan\Rules\Rector\Fixture;

use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Rector\RuleDoc\CodeSample\CodeSample;
use Rector\RuleDoc\Contract\DocumentedRuleInterface;
use Rector\RuleDoc\RuleDefinition;
use PhpParser\Node;

class MissingConfiguredSampleRector extends AbstractRector implements ConfigurableRectorInterface, DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('description', [
            new CodeSample('code', 'code')
        ]);
    }

    public function getNodeTypes(): array
    {
        return [];
    }

    public function refactor(Node $node): ?Node
    {
        return null;
    }

    public function configure(array $configuration): void
    {
    }
}
