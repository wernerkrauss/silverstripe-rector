<?php

namespace Netwerkstatt\SilverstripeRector\Rector\Injector;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Type\ObjectType;
use PHPStan\Reflection\ReflectionProvider;
use Rector\Php80\NodeAnalyzer\PhpAttributeAnalyzer;
use Rector\PhpAttribute\NodeFactory\PhpAttributeGroupFactory;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class UseCreateRector extends AbstractRector implements DocumentedRuleInterface
{
    /**
     * @readonly
     */
    private \PHPStan\Reflection\ReflectionProvider $reflectionProvider;

    public function __construct(ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Code Style: Change new Object to static call for classes that use Injectable trait',
            [
                new CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        new InjectableClass($name);
    }
}
CODE_SAMPLE
                , <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        InjectableClass::create($name);
    }
}
CODE_SAMPLE
            )
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getNodeTypes(): array
    {
        return [New_::class];
    }

    /**
     * @param New_ $node
     */
    public function refactor(Node $node): ?Node
    {
        $traits = [];
        $class = $node->class;
        if (!method_exists($class, 'toString')) {
            return null; //we have something like "new $foo"
        }

        $className = $class->toString();
        if (!$this->reflectionProvider->hasClass($className)) {
            return null;
        }

        $classReflection = $this->reflectionProvider->getClass($className);

        if (!$classReflection->hasTraitUse(\SilverStripe\Core\Injector\Injectable::class)) {
            return null;
        }

        return $this->nodeFactory->createStaticCall($node->class, 'create', $node->args);
    }
}
