<?php

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ObjectType;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Silverstripe: Adds a deprecation comment to classes or methods that are deprecated in Silverstripe.
 *
 * This Rector is intended for deprecations where no direct replacement exists, but a notification
 * and a link to the documentation or an issue should be provided.
 *
 * Configuration format:
 *
 * [
 *     'Some\Class' => [
 *         'message' => 'This class is deprecated.',
 *         'link' => 'https://...',
 *     ],
 *     'Some\Class::methodName' => [
 *         'message' => 'This method is deprecated.',
 *         'link' => 'https://...',
 *     ],
 * ]
 */
final class SilverstripeDeprecationCommentRector extends AbstractRector implements
    ConfigurableRectorInterface,
    DocumentedRuleInterface
{
    /**
     * @var array<string, array{message: string, link: string}>
     */
    private array $configuration = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe: Add deprecation comments to classes or methods without direct substitute.',
            [
                new ConfiguredCodeSample(
                    <<<'PHP'
class SomeClass
{
    public function oldMethod()
    {
    }
}
PHP,
                    <<<'PHP'
class SomeClass
{
    /**
     * @deprecated This method is deprecated.
     * See: https://docs.silverstripe.org/...
     */
    public function oldMethod()
    {
    }
}
PHP,
                    [
                        'SomeClass::oldMethod' => [
                            'message' => 'This method is deprecated.',
                            'link' => 'https://docs.silverstripe.org/...',
                        ],
                    ]
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Class_::class, ClassMethod::class];
    }

    /**
     * @param Class_|ClassMethod $node
     */
    public function refactor(Node $node): ?Node
    {
        foreach ($this->configuration as $target => $info) {
            if (strpos($target, '::') !== false) {
                if (!$node instanceof ClassMethod) {
                    continue;
                }

                [$className, $methodName] = explode('::', $target);

                if (!$this->isName($node->name, $methodName)) {
                    continue;
                }

                $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
                if (!$scope instanceof \PHPStan\Analyser\Scope) {
                    continue;
                }

                $classReflection = $scope->getClassReflection();
                if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
                    continue;
                }

                if ($classReflection->getName() === $className || $classReflection->isSubclassOf($className)) {
                    return $this->addDeprecationComment($node, $info);
                }
            } else {
                if (!$node instanceof Class_) {
                    continue;
                }

                if ($this->isObjectType($node, new ObjectType($target))) {
                    return $this->addDeprecationComment($node, $info);
                }
            }
        }

        return null;
    }

    /**
     * @param array{message: string, link: string} $info
     */
    private function addDeprecationComment(Node $node, array $info): ?Node
    {
        $commentText = sprintf(
            "/**\n * @deprecated %s\n * See: %s\n */",
            $info['message'],
            $info['link']
        );

        // Check if comment already exists to avoid duplicates
        $comments = $node->getComments();
        foreach ($comments as $comment) {
            if (strpos($comment->getText(), $info['link']) !== false) {
                return null;
            }
        }

        $node->setDocComment(new Comment\Doc($commentText));

        return $node;
    }

    public function configure(array $configuration): void
    {
        $this->configuration = $configuration;
    }
}
