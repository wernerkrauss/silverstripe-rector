<?php

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Type\ObjectType;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\PhpParser\Node\BetterNodeFinder;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Silverstripe: Removes a deprecation comment that was added by SilverstripeDeprecationCommentRector
 * but is no longer needed because the method or class has been renamed/replaced.
 *
 * Configuration format: Same as SilverstripeDeprecationCommentRector, but targets the NEW names.
 */
final class RemoveSilverstripeDeprecationCommentRector extends AbstractRector implements
    ConfigurableRectorInterface,
    DocumentedRuleInterface
{
    /**
     * @var array<string, array{message: string, link: string}>
     */
    private array $configuration = [];

    private BetterNodeFinder $betterNodeFinder;

    public function __construct(BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe: Remove deprecation comments that are no longer applicable after upgrade.',
            [
                new ConfiguredCodeSample(
                    <<<'PHP'
class SomeClass
{
    /**
     * @deprecated This method is deprecated. Use newMethod() instead.
     * See: https://docs.silverstripe.org/...
     */
    public function newMethod()
    {
    }
}
PHP,
                    <<<'PHP'
class SomeClass
{
    public function newMethod()
    {
    }
}
PHP,
                    [
                        'SomeClass::newMethod' => [
                            'message' => 'This method is deprecated.',
                            'link' => 'https://docs.silverstripe.org/...',
                        ],
                    ]
                ),
            ]
        );
    }

    public function getNodeTypes(): array
    {
        return [
            ClassLike::class,
            ClassMethod::class,
            Expression::class,
            Return_::class,
        ];
    }

    /**
     * @param Class_|ClassMethod|Expression|Return_ $node
     */
    public function refactor(Node $node): ?Node
    {
        $hasChanged = false;
        foreach ($this->configuration as $target => $info) {
            $link = $info['link'];

            if ($node instanceof ClassLike || $node instanceof ClassMethod) {
                $shouldRemove = $this->shouldRemoveCommentFromDeclaration($node, $target);
                if ($shouldRemove && $this->removeComment($node, $link)) {
                    $hasChanged = true;
                }
            }

            if ($node instanceof Expression || $node instanceof Return_) {
                $shouldRemove = $this->shouldRemoveCommentFromStatement($node, $target);
                if ($shouldRemove && $this->removeComment($node, $link)) {
                    $hasChanged = true;
                }
            }
        }

        return $hasChanged ? $node : null;
    }

    private function shouldRemoveCommentFromDeclaration(Node $node, string $target): bool
    {
        if (strpos($target, '::') !== false) {
            if (!$node instanceof ClassMethod) {
                return false;
            }

            [$className, $methodName] = explode('::', $target);

            // 1. Direct match: The method itself is the target
            if ($this->isName($node->name, $methodName)) {
                $class = $this->findParentClassLike($node);
                if ($class instanceof ClassLike
                    && ($this->isName($class, $className) || $this->isObjectType($class, new ObjectType($className)))
                ) {
                    return true;
                }

                $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
                if ($scope instanceof \PHPStan\Analyser\Scope) {
                    $classReflection = $scope->getClassReflection();
                    if ($classReflection instanceof \PHPStan\Reflection\ClassReflection
                        && ($classReflection->getName() === $className || $classReflection->isSubclassOf($className))
                    ) {
                        return true;
                    }
                }
            }

            // 2. Indirect match: The method contains a call to the target
            return $this->shouldRemoveCommentFromStatement($node, $target);
        }

        if (!$node instanceof Class_) {
            return false;
        }

        if ($this->isName($node, $target)) {
            return true;
        }

        return $this->isObjectType($node, new ObjectType($target));
    }

    private function findParentClassLike(Node $node): ?ClassLike
    {
        $parent = $node->getAttribute('parent');
        while ($parent instanceof Node) {
            if ($parent instanceof ClassLike) {
                return $parent;
            }

            $parent = $parent->getAttribute('parent');
        }

        return null;
    }

    private function shouldRemoveCommentFromStatement(Node $node, string $target): bool
    {
        if (strpos($target, '::') === false) {
            return false;
        }

        [$className, $methodName] = explode('::', $target);

        return (bool)$this->betterNodeFinder->findFirst(
            $node,
            function (Node $subNode) use ($className, $methodName): bool {
                if (!($subNode instanceof MethodCall || $subNode instanceof StaticCall
                    || $subNode instanceof PropertyFetch || $subNode instanceof StaticPropertyFetch)) {
                    return false;
                }

                if (!$this->isName($subNode->name, $methodName)) {
                    return false;
                }

                $objectTypeNode = $subNode instanceof MethodCall
                    ? $subNode->var
                    : ($subNode instanceof StaticCall || $subNode instanceof StaticPropertyFetch
                        ? $subNode->class
                        : $subNode->var);

                return $this->isObjectType($objectTypeNode, new ObjectType($className));
            }
        );
    }

    private function removeComment(Node $node, string $link): bool
    {
        $docComment = $node->getDocComment();
        if (!$docComment instanceof \PhpParser\Comment\Doc) {
            return false;
        }

        $text = $docComment->getText();

        // Use a more robust approach to parse and remove the block
        $lines = explode("\n", $text);
        $newLines = [];
        $isInsideDeprecatedToRemove = false;
        $hasChanged = false;

        for ($i = 0, $count = count($lines); $i < $count; $i++) {
            $line = $lines[$i];
            $trimmedLine = trim($line);

            // Start of a @deprecated tag
            if (strpos($trimmedLine, '@deprecated') !== false) {
                // Peek ahead to see if the link is in this block
                $foundLink = false;
                for ($j = 0; $j <= 10; $j++) {
                    if (isset($lines[$i + $j])) {
                        if (strpos($lines[$i + $j], $link) !== false) {
                            $foundLink = true;
                            break;
                        }

                        // If we hit another tag or end of comment, the block ended
                        $peekTrimmed = trim($lines[$i + $j]);
                        if ($j > 0 && (strpos($peekTrimmed, '* @') !== false || $peekTrimmed === '*/')) {
                            break;
                        }
                    }
                }

                if ($foundLink) {
                    $isInsideDeprecatedToRemove = true;
                    $hasChanged = true;
                    continue;
                }
            }

            if ($isInsideDeprecatedToRemove) {
                // We are inside a block to remove.
                // We stop removing when we hit the next tag or the end of the docblock
                if (strpos($trimmedLine, '* @') !== false || $trimmedLine === '*/') {
                    $isInsideDeprecatedToRemove = false;
                    // Don't continue, we need to keep this line (unless it's the start of another @deprecated
                    // we might want to remove, but that's handled in the next iteration)
                } else {
                    continue;
                }
            }

            $newLines[] = $line;
        }

        if ($hasChanged) {
            // Check if only /** and */ remain (ignoring empty lines with only *)
            $contentLines = array_values(array_filter(
                array_map('trim', $newLines),
                static function ($l): bool {
                    $trimmed = trim($l);
                    return !in_array($trimmed, ['*', '/**', '*/', ''], true);
                }
            ));
            
            if ($contentLines === []) {
                $node->setAttribute('comments', []);
                return true;
            }

            $newText = implode("\n", $newLines);
            $node->setDocComment(new \PhpParser\Comment\Doc($newText));
            return true;
        }

        return false;
    }

    public function configure(array $configuration): void
    {
        $this->configuration = $configuration;
    }
}
