<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use PhpParser\BuilderHelpers;
use Rector\Comments\NodeDocBlock\DocBlockUpdater;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Rector\PhpParser\Node\BetterNodeFinder;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class StaticCallToConfigRector extends AbstractRector implements
    ConfigurableRectorInterface,
    DocumentedRuleInterface
{
    /**
     * @var array<string, array<string, array{property: string, value: mixed, visibility?: int, add_config?: bool}>>
     */
    private $classMethodCallMap = [];

    /**
     * @var DocBlockUpdater
     */
    private $docBlockUpdater;

    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;

    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;

    public function __construct(
        DocBlockUpdater $docBlockUpdater,
        PhpDocInfoFactory $phpDocInfoFactory,
        BetterNodeFinder $betterNodeFinder
    ) {
        $this->docBlockUpdater = $docBlockUpdater;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->betterNodeFinder = $betterNodeFinder;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Convert static method calls to config properties', [
            new ConfiguredCodeSample(
                <<<'CODE_SAMPLE'
class MyObject extends DataObject
{
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        self::disable_subclass_access();
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
class MyObject extends DataObject
{
    /**
     * @config
     */
    private static $subclass_access = false;
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
    }
}
CODE_SAMPLE
                ,
                [
                    \SilverStripe\ORM\DataObject::class => [
                        'disable_subclass_access' => [
                            'property' => 'subclass_access',
                            'value' => false,
                            'visibility' => \PhpParser\Modifiers::PRIVATE | \PhpParser\Modifiers::STATIC,
                            'add_config' => true
                        ],
                    ],
                ]
            ),
        ]);
    }

    public function getNodeTypes(): array
    {
        return [Class_::class];
    }

    /**
     * @param Class_ $node
     */
    public function refactor(Node $node): ?Node
    {
        $hasChanged = false;

        foreach ($this->classMethodCallMap as $type => $methodMap) {
            if (!$this->isObjectType($node, new ObjectType($type))) {
                continue;
            }

            foreach ($methodMap as $methodName => $config) {
                $calls = $this->betterNodeFinder->find(
                    $node,
                    fn(Node $subNode) => $subNode instanceof StaticCall && $this->isName($subNode->name, $methodName)
                );

                if ($calls === []) {
                    continue;
                }

                foreach ($calls as $call) {
                    $this->removeStaticCall($node, $call);
                    $hasChanged = true;
                }

                $this->addConfigProperty($node, $config);
            }
        }

        return $hasChanged ? $node : null;
    }

    private function removeStaticCall(Class_ $class, StaticCall $staticCall): void
    {
        foreach ($class->stmts as $stmt) {
            if (!$stmt instanceof ClassMethod) {
                continue;
            }

            if ($stmt->stmts === null) {
                continue;
            }

            foreach ($stmt->stmts as $key => $methodStmt) {
                if ($methodStmt instanceof Expression && $methodStmt->expr === $staticCall) {
                    unset($stmt->stmts[$key]);
                    return;
                }
            }
        }
    }

    private function addConfigProperty(Class_ $class, array $config): void
    {
        $propertyName = $config['property'];
        if ($class->getProperty($propertyName) instanceof \PhpParser\Node\Stmt\Property) {
            return;
        }

        $property = new Property(
            $config['visibility'] ?? (\PhpParser\Modifiers::PRIVATE | \PhpParser\Modifiers::STATIC),
            [new Node\Stmt\PropertyProperty($propertyName, BuilderHelpers::normalizeValue($config['value']))]
        );

        if ($config['add_config'] ?? false) {
            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
            $phpDocInfo->addPhpDocTagNode(new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode('@config'));
            $this->docBlockUpdater->updateRefactoredNodeWithPhpDocInfo($property);
        }

        // Add property at the beginning of the class
        array_unshift($class->stmts, $property);
    }

    public function configure(array $configuration): void
    {
        $this->classMethodCallMap = $configuration;
    }
}
