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
 * @see \Netwerkstatt\SilverstripeRector\Tests\ORM\SortRawSqlToOrderByRector\SortRawSqlToOrderByRectorTest
 */
final class SortRawSqlToOrderByRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 5.0: Migrate raw SQL expressions in DataList::sort() to DataList::orderBy(). '
            . 'Plain field names, field/direction strings and sort arrays keep using sort().',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
$pages = $list->sort("FIELD(Status, 'Draft', 'Published')");
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
$pages = $list->orderBy("FIELD(Status, 'Draft', 'Published')");
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
        if (!$this->isName($node->name, 'sort')) {
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

        if (!$this->looksLikeRawSql($arg->value)) {
            return null;
        }

        $node->name = new Identifier('orderBy');
        return $node;
    }

    private function looksLikeRawSql(string $sortString): bool
    {
        return preg_match('/[A-Za-z_][A-Za-z0-9_]*\s*\(/', $sortString) === 1;
    }
}
