<?php

declare (strict_types=1);
namespace Netwerkstatt\SilverstripeRector\Rector\DataObject;

use PhpParser\Node;
use PHPStan\Type\ObjectType;
use RectorPrefix20211231\Symplify\Astral\ValueObject\NodeBuilder\PropertyBuilder;

/**

* @see \Rector\Tests\SS4\Rector\Class_\EnsureTableNameIsSetRector\EnsureTableNameIsSetRectorTest
*/
final class EnsureTableNameIsSetRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('DataObject subclasses must have "$table_name" defined', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return array(\PhpParser\Node\Stmt\Class_::class);
    }
    /**
     * @param \PhpParser\Node\Stmt\Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isObjectType($node, new ObjectType('SilverStripe\ORM\DataObject'))) {
            return null;
        }

        //check if table_name is already set; don't modify
        if ($node->getProperty('table_name')) {
            return null;
        }

        $name = $this->nodeNameResolver->getShortName($this->getName($node));
        // change the node
        $tableName = new PropertyBuilder('table_name');
        $tableName->makePrivate();
        $tableName->makeStatic();
        $tableName->setDefault($name);

        array_unshift($node->stmts, $tableName->getNode(), new Node\Stmt\Nop());

        return $node;
    }
}
