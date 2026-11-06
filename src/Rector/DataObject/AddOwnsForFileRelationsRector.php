<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\DataObject;

use PhpParser\Modifiers;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassProperty;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use PHPStan\Type\ObjectType;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Rector\RuleDoc\CodeSample\CodeSample;
use Rector\RuleDoc\CodeSample\ConfiguredCodeSample;
use Rector\RuleDoc\Contract\DocumentedRuleInterface;
use Rector\RuleDoc\RuleDefinition;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRector\AddOwnsForFileRelationsRectorTest
 * @see \Netwerkstatt\SilverstripeRector\Tests\DataObject\AddOwnsForFileRelationsRectorWithConfig\AddOwnsForFileRelationsRectorWithConfigTest
 */
final class AddOwnsForFileRelationsRector extends AbstractRector implements
    ConfigurableRectorInterface,
    DocumentedRuleInterface
{
    public const EXCLUDE_CLASSES = 'exclude_classes';

    public const ADDITIONAL_OWNED_CLASSES = 'additional_owned_classes';

    public const EXCLUDE_RELATIONS = 'exclude_relations';

    private const RELATION_PROPERTIES = ['has_one', 'has_many', 'many_many'];

    /**
     * @var array<class-string>
     */
    private array $excludeClasses = [];

    /**
     * @var array<class-string>
     */
    private array $additionalOwnedClasses = [];

    /**
     * @var string[]
     */
    private array $excludeRelations = [];

    /**
     * @param array<string, mixed> $configuration
     */
    public function configure(array $configuration): void
    {
        $this->excludeClasses = (array) ($configuration[self::EXCLUDE_CLASSES] ?? []);
        $this->additionalOwnedClasses = (array) ($configuration[self::ADDITIONAL_OWNED_CLASSES] ?? []);
        $this->excludeRelations = (array) ($configuration[self::EXCLUDE_RELATIONS] ?? []);
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Code Style: Add missing $owns entries for relations to File and Image declared via '
            . '$has_one, $has_many or $many_many.',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class Product extends DataObject
{
    private static $has_one = [
        'Image' => Image::class,
    ];
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class Product extends DataObject
{
    private static $has_one = [
        'Image' => Image::class,
    ];

    private static $owns = [
        'Image',
    ];
}
CODE_SAMPLE
                ),
                new ConfiguredCodeSample(
                    <<<'CODE_SAMPLE'
use SilverStripe\ORM\DataObject;

class Product extends DataObject
{
    private static $has_one = [
        'Attachment' => \Vendor\Module\Document::class,
    ];
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
use SilverStripe\ORM\DataObject;

class Product extends DataObject
{
    private static $has_one = [
        'Attachment' => \Vendor\Module\Document::class,
    ];

    private static $owns = [
        'Attachment',
    ];
}
CODE_SAMPLE
                    ,
                    [self::ADDITIONAL_OWNED_CLASSES => ['Vendor\Module\Document']]
                ),
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
    public function refactor(Node $node): ?Node
    {
        if (!$this->isObjectType($node, new ObjectType(DataObject::class))) {
            return null;
        }

        $className = $node->namespacedName !== null ? $node->namespacedName->toString() : '';
        foreach ($this->excludeClasses as $excludeClass) {
            if ($className !== '' && is_a($className, ltrim($excludeClass, '\\'), true)) {
                return null;
            }
        }

        $ownedRelations = $this->collectOwnedRelations($node);
        if ($ownedRelations === []) {
            return null;
        }

        return $this->addOwnsProperty($node, $ownedRelations);
    }

    /**
     * @return string[]
     */
    private function collectOwnedRelations(Class_ $node): array
    {
        $owned = [];
        foreach (self::RELATION_PROPERTIES as $propertyName) {
            $property = $this->findStmtProperty($node, $propertyName);
            $default = $this->propertyDefault($property);
            if (!$default instanceof Array_) {
                continue;
            }

            foreach ($default->items as $item) {
                if (!$item instanceof ArrayItem || !$item->key instanceof String_) {
                    continue;
                }

                $relationName = $item->key->value;
                if (in_array($relationName, $this->excludeRelations, true)) {
                    continue;
                }

                if ($this->isOwnedTarget($item->value)) {
                    $owned[$relationName] = $relationName;
                }
            }
        }

        return array_values($owned);
    }

    private function isOwnedTarget(Expr $value): bool
    {
        $targetClass = null;
        if ($value instanceof ClassConstFetch) {
            $targetClass = $this->getName($value->class);
        } elseif ($value instanceof String_) {
            $targetClass = $value->value;
        }

        if ($targetClass === null) {
            return false;
        }

        $targetClass = ltrim($targetClass, '\\');
        if (is_a($targetClass, File::class, true) || is_a($targetClass, Image::class, true)) {
            return true;
        }

        foreach ($this->additionalOwnedClasses as $ownedClass) {
            if (is_a($targetClass, ltrim($ownedClass, '\\'), true)) {
                return true;
            }
        }

        return false;
    }

    private function findStmtProperty(Class_ $node, string $name): ?Stmt
    {
        foreach ($node->stmts as $stmt) {
            if (!$stmt instanceof Property && !$stmt instanceof ClassProperty) {
                continue;
            }

            if ($this->getName($stmt) === $name) {
                return $stmt;
            }
        }

        return null;
    }

    private function propertyDefault(?Stmt $property): ?Expr
    {
        if (!$property instanceof Property && !$property instanceof ClassProperty) {
            return null;
        }

        $prop = $property->props[0] ?? null;
        return $prop instanceof PropertyProperty ? $prop->default : null;
    }

    /**
     * @param string[] $ownedRelations
     */
    private function addOwnsProperty(Class_ $node, array $ownedRelations): ?Class_
    {
        $ownsProperty = $this->findStmtProperty($node, 'owns');
        $ownsDefault = $this->propertyDefault($ownsProperty);
        if ($ownsProperty instanceof Property || $ownsProperty instanceof ClassProperty) {
            if (!$ownsDefault instanceof Array_) {
                return null;
            }

            $existing = [];
            foreach ($ownsDefault->items as $item) {
                if ($item instanceof ArrayItem && $item->value instanceof String_) {
                    $existing[$item->value->value] = true;
                }
            }

            $changed = false;
            foreach ($ownedRelations as $relationName) {
                if (isset($existing[$relationName])) {
                    continue;
                }

                $ownsDefault->items[] = new ArrayItem(new String_($relationName));
                $existing[$relationName] = true;
                $changed = true;
            }

            return $changed ? $node : null;
        }

        $items = [];
        foreach ($ownedRelations as $relationName) {
            $items[] = new ArrayItem(new String_($relationName));
        }

        $node->stmts[] = new Property(
            Modifiers::PRIVATE | Modifiers::STATIC,
            [new PropertyProperty('owns', new Array_($items))]
        );

        return $node;
    }
}
