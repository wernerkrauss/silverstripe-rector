<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\ORM;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Arg;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\ORM\GetIDListToColumnIDRector\GetIDListToColumnIDRectorTest
 */
final class GetIDListToColumnIDRector extends AbstractRector implements DocumentedRuleInterface
{
    private const CLASSES_WITH_SORT = [
        \SilverStripe\ORM\DataList::class,
        \SilverStripe\ORM\Relation::class,
    ];

    private const CLASSES_WITHOUT_SORT = [
        \SilverStripe\ORM\EagerLoadedList::class,
        \SilverStripe\ORM\UnsavedRelationList::class,
    ];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            "Silverstripe 6.2: Replace getIDList() with sort(null)->column('ID') or column('ID')",
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
$dataList->getIDList();
$eagerLoadedList->getIDList();
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
$dataList->sort(null)->column('ID');
$eagerLoadedList->column('ID');
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
        if (!$this->isName($node->name, 'getIDList')) {
            return null;
        }

        foreach (self::CLASSES_WITH_SORT as $class) {
            if ($this->isObjectType($node->var, new ObjectType($class))) {
                $sortCall = new MethodCall($node->var, 'sort', [new Arg(new ConstFetch(new Name('null')))]);
                return new MethodCall($sortCall, 'column', [new Arg(new String_('ID'))]);
            }
        }

        foreach (self::CLASSES_WITHOUT_SORT as $class) {
            if ($this->isObjectType($node->var, new ObjectType($class))) {
                return new MethodCall($node->var, 'column', [new Arg(new String_('ID'))]);
            }
        }

        return null;
    }
}
