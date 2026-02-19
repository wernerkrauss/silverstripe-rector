<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Config;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\Config\StatToConfigGetRector\StatToConfigGetRectorTest
 */
final class StatToConfigGetRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 4.0: Replace $this->stat(\'foo\') with static::config()->get(\'foo\')',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
class MyClass {
    use \SilverStripe\Core\Config\Configurable;
    public function myMethod() {
        $this->stat('foo');
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
class MyClass {
    use \SilverStripe\Core\Config\Configurable;
    public function myMethod() {
        static::config()->get('foo');
    }
}
CODE_SAMPLE
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [MethodCall::class];
    }

    /**
     * @param MethodCall $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isObjectType($node->var, new ObjectType(\SilverStripe\Core\Config\Configurable::class))
        ) {
            return null;
        }

        if (!$this->isName($node->name, 'stat')) {
            return null;
        }

        if (count($node->args) < 1) {
            return null;
        }

        $configStaticCall = new StaticCall(new Name('static'), 'config');
        return new MethodCall($configStaticCall, 'get', [$node->args[0]]);
    }
}
