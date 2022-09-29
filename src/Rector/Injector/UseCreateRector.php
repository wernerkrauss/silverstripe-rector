<?php

namespace Netwerkstatt\SilverstripeRector\Rector\Injector;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Type\ObjectType;
use PHPStan\Reflection\ReflectionProvider;
use Rector\Php80\NodeAnalyzer\PhpAttributeAnalyzer;
use Rector\PhpAttribute\NodeFactory\PhpAttributeGroupFactory;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class UseCreateRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @readonly
     * @var ReflectionProvider
     */
    private $reflectionProvider;

    public function __construct(ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Change new Object to static call for classes that use Injectable trait', [
            new ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getNodeTypes(): array
    {
        return [New_::class];
    }

    /**
     * @inheritDoc
     */
    public function refactor(Node $node): ?Node
    {
        $traits = [];
        $className = $node->class->toString();
        if (!$this->reflectionProvider->hasClass($className)) {
            return null;
        }

        $classReflection = $this->reflectionProvider->getClass($className);

        if (!$classReflection->hasTraitUse('SilverStripe\Core\Injector\Injectable')) {
            return null;
        }

        return $this->nodeFactory->createStaticCall($node->class, 'create', $node->args);
    }
}