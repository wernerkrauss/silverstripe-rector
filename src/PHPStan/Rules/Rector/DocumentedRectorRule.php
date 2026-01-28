<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\PHPStan\Rules\Rector;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;

/**
 * @implements Rule<Class_>
 */
final class DocumentedRectorRule implements Rule
{
    private ReflectionProvider $reflectionProvider;

    public function __construct(ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getNodeType(): string
    {
        return Class_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->isAbstract() || $node->namespacedName === null) {
            return [];
        }

        $className = $node->namespacedName->toString();
        if (!$this->reflectionProvider->hasClass($className)) {
            return [];
        }

        $classReflection = $this->reflectionProvider->getClass($className);

        if (!$classReflection->isSubclassOf(AbstractRector::class)) {
            return [];
        }

        $errors = [];

        if (!$classReflection->isSubclassOf(DocumentedRuleInterface::class)) {
            $errors[] = RuleErrorBuilder::message(sprintf(
                'Rector "%s" must implement "%s".',
                $className,
                DocumentedRuleInterface::class
            ))
                ->identifier('silverstripeRector.missingDocumentedInterface')
                ->build();
            
            return $errors;
        }

        if (!$node->getMethod('getRuleDefinition')) {
            $errors[] = RuleErrorBuilder::message(sprintf(
                'Rector "%s" implements "%s" but is missing "getRuleDefinition()" method.',
                $className,
                DocumentedRuleInterface::class
            ))
                ->identifier('silverstripeRector.missingRuleDefinition')
                ->build();
            
            return $errors;
        }

        if (!$classReflection->isSubclassOf(ConfigurableRectorInterface::class)) {
            return $errors;
        }

        // We want to check if the getRuleDefinition returns ConfiguredCodeSample
        // This is a bit hard to do by just looking at the AST without full analysis,
        // but we can try to find the return statement in getRuleDefinition.
        
        $getRuleDefinition = $node->getMethod('getRuleDefinition');
        $hasConfiguredCodeSample = false;
        
        if ($getRuleDefinition->stmts !== null) {
            foreach ($getRuleDefinition->stmts as $stmt) {
                if ($stmt instanceof Node\Stmt\Return_
                    && $stmt->expr instanceof \PhpParser\Node\Expr
                    && $this->containsConfiguredCodeSample($stmt->expr)
                ) {
                    $hasConfiguredCodeSample = true;
                    break;
                }
            }
        }

        if (!$hasConfiguredCodeSample) {
            $errors[] = RuleErrorBuilder::message(sprintf(
                'Rector "%s" implements "%s" and "%s", so it must return "%s" in "getRuleDefinition()".',
                $className,
                DocumentedRuleInterface::class,
                ConfigurableRectorInterface::class,
                ConfiguredCodeSample::class
            ))
                ->identifier('silverstripeRector.missingConfiguredCodeSample')
                ->build();
        }

        return $errors;
    }

    private function containsConfiguredCodeSample(Node $node): bool
    {
        if ($node instanceof Node\Expr\New_ && $node->class instanceof Node\Name) {
            $className = $node->class->toString();
            if ($className === 'ConfiguredCodeSample' || $className === ConfiguredCodeSample::class) {
                return true;
            }
        }

        if ($node instanceof Node\Expr\Array_) {
            foreach ($node->items as $item) {
                if ($item instanceof Node\ArrayItem && $this->containsConfiguredCodeSample($item->value)) {
                    return true;
                }
            }
        }

        foreach ($node->getSubNodeNames() as $subNodeName) {
            $subNode = $node->$subNodeName;
            if ($subNode instanceof Node) {
                if ($this->containsConfiguredCodeSample($subNode)) {
                    return true;
                }
            } elseif (is_array($subNode)) {
                foreach ($subNode as $item) {
                    if ($item instanceof Node && $this->containsConfiguredCodeSample($item)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
