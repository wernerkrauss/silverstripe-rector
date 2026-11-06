<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Config;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;
use Rector\RuleDoc\CodeSample\CodeSample;
use Rector\RuleDoc\Contract\DocumentedRuleInterface;
use Rector\RuleDoc\RuleDefinition;
use SilverStripe\Core\Config\Config;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\Config\ConfigUpdateToSetMergeRector\ConfigUpdateToSetMergeRectorTest
 */
final class ConfigUpdateToSetMergeRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 5.0: Replace deprecated Config::inst()->update() with Config::modify()->set() '
            . 'or Config::modify()->merge() (merge when the value is an array, set otherwise).',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
use SilverStripe\Core\Config\Config;

Config::inst()->update('MyClass', 'my_prop', 'value');
Config::inst()->update('MyClass', 'my_list', ['a' => 'b']);
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
use SilverStripe\Core\Config\Config;

Config::modify()->set('MyClass', 'my_prop', 'value');
Config::modify()->merge('MyClass', 'my_list', ['a' => 'b']);
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
        if (!$this->isName($node->name, 'update')) {
            return null;
        }

        if (!$this->isConfigInstance($node->var)) {
            return null;
        }

        if (count($node->args) !== 3) {
            return null;
        }

        $value = $node->args[2]->value;
        $methodName = $value instanceof Array_ ? 'merge' : 'set';

        $node->var = new StaticCall(new FullyQualified(Config::class), 'modify');
        $node->name = new Identifier($methodName);
        return $node;
    }

    private function isConfigInstance(Expr $expr): bool
    {
        if ($expr instanceof StaticCall && $this->isName($expr->name, 'inst')
            && $this->isObjectType($expr->class, new ObjectType(Config::class))
        ) {
            return true;
        }

        return $this->isObjectType($expr, new ObjectType(Config::class));
    }
}
