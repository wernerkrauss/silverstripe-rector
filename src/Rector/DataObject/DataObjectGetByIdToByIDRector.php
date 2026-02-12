<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\DataObject;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\String_;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectGetByIdToByIDRector\DataObjectGetByIdToByIDRectorTest
 */
class DataObjectGetByIdToByIDRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Code Style: Changes DataObject::get_by_id(\'ClassName\', $id) to ClassName::get()->byID($id)',
            [
                new CodeSample(
                    'DataObject::get_by_id(\'MyPage\', $id);',
                    'MyPage::get()->byID($id);'
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [StaticCall::class];
    }

    /**
     * @param StaticCall $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isObjectType($node->class, new \PHPStan\Type\ObjectType(\SilverStripe\ORM\DataObject::class))) {
            return null;
        }

        if (!$this->isName($node->name, 'get_by_id')) {
            return null;
        }

        if (count($node->args) < 2) {
            return null;
        }

        $classNameArg = $node->args[0]->value;
        $idArg = $node->args[1]->value;

        $className = null;
        if ($classNameArg instanceof String_) {
            $className = $classNameArg->value;
            if (strpos($className, '\\') !== false) {
                $className = '\\' . ltrim($className, '\\');
            }
        } elseif ($classNameArg instanceof ClassConstFetch && $this->isName($classNameArg->name, 'class')) {
            $className = $this->getName($classNameArg->class);
        }

        if ($className === null) {
            return null;
        }

        if ($className === 'self' || $className === 'static') {
            $staticCallGet = new StaticCall(new Node\Name($className), 'get');
        } else {
            $staticCallGet = new StaticCall(new FullyQualified(ltrim($className, '\\')), 'get');
        }

        return $this->nodeFactory->createMethodCall($staticCallGet, 'byID', [$idArg]);
    }
}
