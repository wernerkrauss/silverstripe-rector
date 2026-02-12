<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\ORM;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\MethodCall;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\ORM\ListFilterToArrayRector\ListFilterToArrayRectorTest
 */
class ListFilterToArrayRector extends AbstractRector implements DocumentedRuleInterface
{
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
        if (!$this->isNames($node->name, ['filter', 'exclude', 'filterAny', 'excludeAny'])) {
            return null;
        }

        if (count($node->args) !== 2) {
            return null;
        }

        if (!$this->isObjectType($node->var, new \PHPStan\Type\ObjectType('SilverStripe\ORM\DataList')) &&
            !$this->isObjectType($node->var, new \PHPStan\Type\ObjectType('SilverStripe\ORM\ArrayList'))
        ) {
            return null;
        }

        $arg0 = $node->args[0]->value;
        $arg1 = $node->args[1]->value;

        // If first arg is already an array, do nothing
        if ($arg0 instanceof Array_) {
            return null;
        }

        $array = new Array_([
            new ArrayItem($arg1, $arg0)
        ]);

        $node->args = [$this->nodeFactory->createArg($array)];

        return $node;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Code Style: Translates Silverstripe ORM filter() and similar calls from string notation to array ' .
            'notation.',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
$list->filter('key', 'value');
$list->exclude('key', 'value');
$list->filterAny('key', 'value');
$list->excludeAny('key', 'value');
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
$list->filter(['key' => 'value']);
$list->exclude(['key' => 'value']);
$list->filterAny(['key' => 'value']);
$list->excludeAny(['key' => 'value']);
CODE_SAMPLE
                ),
            ]
        );
    }
}
