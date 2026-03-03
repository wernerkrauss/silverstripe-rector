<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\DataObject;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Arg;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\DataObject\DataObjectStaticMethodsToFluentRector\DataObjectStaticMethodsToFluentRectorTest
 */
final class DataObjectStaticMethodsToFluentRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 6.1: Replace DataObject static methods get_by_id(), get_one(), and delete_by_id() ' .
            'with fluent equivalents.',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
DataObject::get_by_id($className, $id);
DataObject::get_one($className, $filter);
DataObject::delete_by_id($className, $id);
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
DataObject::get($className)->setUseCache(true)->byID($id);
DataObject::get($className)->setUseCache(true)->filter($filter)->first();
DataObject::get($className)->setUseCache(true)->byID($id)->delete();
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
        return [StaticCall::class];
    }

    /**
     * @param StaticCall $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isObjectType($node->class, new ObjectType(\SilverStripe\ORM\DataObject::class))) {
            return null;
        }

        if ($this->isName($node->name, 'get_by_id')) {
            return $this->refactorGetById($node);
        }

        if ($this->isName($node->name, 'get_one')) {
            return $this->refactorGetOne($node);
        }

        if ($this->isName($node->name, 'delete_by_id')) {
            return $this->refactorDeleteById($node);
        }

        return null;
    }

    private function refactorGetById(StaticCall $node): ?Node
    {
        if (count($node->args) < 2) {
            return null;
        }

        $classNameArg = $node->args[0];
        $idArg = $node->args[1];

        $getCall = new StaticCall(new Node\Name('DataObject'), 'get', [$classNameArg]);
        $setUseCacheCall = $this->nodeFactory->createMethodCall(
            $getCall,
            'setUseCache',
            [new Arg($this->nodeFactory->createTrue())]
        );

        return $this->nodeFactory->createMethodCall($setUseCacheCall, 'byID', [$idArg]);
    }

    private function refactorGetOne(StaticCall $node): ?Node
    {
        if (count($node->args) < 1) {
            return null;
        }

        $classNameArg = $node->args[0];
        $filterArg = $node->args[1] ?? null;

        $getCall = new StaticCall(new Node\Name('DataObject'), 'get', [$classNameArg]);
        $setUseCacheCall = $this->nodeFactory->createMethodCall(
            $getCall,
            'setUseCache',
            [new Arg($this->nodeFactory->createTrue())]
        );

        $currentCall = $setUseCacheCall;
        if ($filterArg !== null) {
            $currentCall = $this->nodeFactory->createMethodCall($currentCall, 'filter', [$filterArg]);
        }

        return $this->nodeFactory->createMethodCall($currentCall, 'first');
    }

    private function refactorDeleteById(StaticCall $node): ?Node
    {
        if (count($node->args) < 2) {
            return null;
        }

        $classNameArg = $node->args[0];
        $idArg = $node->args[1];

        $getCall = new StaticCall(new Node\Name('DataObject'), 'get', [$classNameArg]);
        $setUseCacheCall = $this->nodeFactory->createMethodCall(
            $getCall,
            'setUseCache',
            [new Arg($this->nodeFactory->createTrue())]
        );
        $byIDCall = $this->nodeFactory->createMethodCall($setUseCacheCall, 'byID', [$idArg]);

        return $this->nodeFactory->createMethodCall($byIDCall, 'delete');
    }
}
