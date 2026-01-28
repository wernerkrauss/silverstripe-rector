<?php

namespace Netwerkstatt\SilverstripeRector\Tests\PHPStan\Rules\Rector\Fixture;

use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use PhpParser\Node;

class CorrectConfigurableRector extends AbstractRector implements ConfigurableRectorInterface, DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('description', [
            new ConfiguredCodeSample('code', 'code', [])
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
