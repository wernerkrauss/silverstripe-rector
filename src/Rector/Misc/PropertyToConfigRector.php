<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use Netwerkstatt\SilverstripeRector\Rector\Misc\PropertyToConfigRector\PropertyToConfigRectorTest;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTagRemover;
use Rector\Comments\NodeDocBlock\DocBlockUpdater;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see PropertyToConfigRectorTest
 */
final class PropertyToConfigRector extends AbstractRector implements
    ConfigurableRectorInterface,
    DocumentedRuleInterface
{
    /**
     * @var DocBlockUpdater
     */
    private $docBlockUpdater;

    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;

    public function __construct(
        DocBlockUpdater $docBlockUpdater,
        PhpDocInfoFactory $phpDocInfoFactory
    ) {
        $this->docBlockUpdater = $docBlockUpdater;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }

    /**
     * @var array<string, array<string, array{name?: string, visibility?: int, add_config?: bool}>>
     */
    private array $classPropertyMap = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Convert protected properties to private static config properties', [
            new ConfiguredCodeSample(
                <<<'CODE_SAMPLE'
class MyTask extends BuildTask
{
    protected $enabled = true;
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
class MyTask extends BuildTask
{
    /**
     * @config
     */
    private static $is_enabled = true;
}
CODE_SAMPLE
                ,
                [
                    \SilverStripe\Dev\BuildTask::class => [
                        'enabled' => [
                            'name' => 'is_enabled',
                            'visibility' => \PhpParser\Modifiers::PRIVATE | \PhpParser\Modifiers::STATIC,
                            'add_config' => true,
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

        foreach ($this->classPropertyMap as $type => $propertyMap) {
            if (!$this->isObjectType($node, new ObjectType($type))) {
                continue;
            }

            foreach ($propertyMap as $oldName => $config) {
                $property = $node->getProperty($oldName);
                if (!$property instanceof Property) {
                    continue;
                }

                if (isset($config['name'])) {
                    $property->props[0]->name = new Node\VarLikeIdentifier($config['name']);
                }

                if (isset($config['visibility'])) {
                    $property->flags = $config['visibility'];
                }

                if ($config['add_config'] ?? false) {
                    $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
                    if (!$phpDocInfo->hasByName('config')) {
                        $phpDocInfo->addPhpDocTagNode(new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode('@config'));
                        $this->docBlockUpdater->updateRefactoredNodeWithPhpDocInfo($property);
                    }
                }

                $hasChanged = true;
            }
        }

        return $hasChanged ? $node : null;
    }

    public function configure(array $configuration): void
    {
        $this->classPropertyMap = $configuration;
    }
}
