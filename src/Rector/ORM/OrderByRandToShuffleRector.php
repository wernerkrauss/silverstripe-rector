<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\ORM;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\String_;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;
use Rector\RuleDoc\CodeSample\CodeSample;
use Rector\RuleDoc\Contract\DocumentedRuleInterface;
use Rector\RuleDoc\RuleDefinition;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\ORM\OrderByRandToShuffleRector\OrderByRandToShuffleRectorTest
 */
final class OrderByRandToShuffleRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 5.1: Use shuffle() instead of orderBy() for random sorting (e.g. orderBy(\'RAND()\')).',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
$list->orderBy('RAND()');
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
$list->shuffle();
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
        if (!$this->isName($node->name, 'orderBy')) {
            return null;
        }

        if (!$this->isObjectType($node->var, new ObjectType(DataList::class))
            && !$this->isObjectType($node->var, new ObjectType(ArrayList::class))
        ) {
            return null;
        }

        if (count($node->args) !== 1) {
            return null;
        }

        $arg = $node->args[0]->value;
        if (!$arg instanceof String_) {
            return null;
        }

        if (preg_match('/^\s*(RAND|RANDOM)\s*\(\s*\)\s*$/i', $arg->value) !== 1) {
            return null;
        }

        $node->name = new Identifier('shuffle');
        $node->args = [];
        return $node;
    }
}
