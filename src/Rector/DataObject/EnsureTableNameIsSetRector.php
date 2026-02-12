<?php

declare (strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\DataObject;

use PhpParser\Builder\Property;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\DataObject\EnsureTableNameIsSetRector\EnsureTableNameIsSetRectorTest
 */
final class EnsureTableNameIsSetRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 4.0: DataObject subclasses must have "$table_name" defined',
            [
                new CodeSample(<<<'CODE_SAMPLE'
class SomeClass extends \SilverStripe\ORM\DataObject
{
    private static $db = [];
}
CODE_SAMPLE
                    , <<<'CODE_SAMPLE'
class SomeClass extends \SilverStripe\ORM\DataObject
{
    private static $table_name = 'SomeClass';

    private static $db = [];
}
CODE_SAMPLE
                )
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Class_::class];
    }

    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node): ?\PhpParser\Node
    {
        if (!$this->isObjectType($node, new ObjectType(\SilverStripe\ORM\DataObject::class))) {
            return null;
        }

        //check if table_name is already set; don't modify
        if ($node->getProperty('table_name') instanceof \PhpParser\Node\Stmt\Property) {
            return null;
        }

        $name = $this->nodeNameResolver->getShortName($this->getName($node));
        // change the node
        $tableName = new Property('table_name');
        $tableName->makePrivate();
        $tableName->makeStatic();
        $tableName->setDefault($name);

        array_unshift($node->stmts, $tableName->getNode(), new Node\Stmt\Nop());

        return $node;
    }
}
