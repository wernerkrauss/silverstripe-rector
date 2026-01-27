<?php

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\Class_;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Replacement for the deprecated PropertyFetchToMethodCallRector without PHPStan/betterNodeFinder dependencies.
 *
 * Configuration format:
 *
 * [
 *     Some\Class::class => [
 *         'propertyName' => 'methodName',
 *     ],
 * ]
 *
 * It matches by the containing class name only.
 */
final class PropertyFetchToMethodCallRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var array<class-string, array<string, string>>
     */
    private array $map = [];

    /**
     * @param array<class-string, array<string, string>> $map
     */
    public function __construct(array $map = [])
    {
        // Optional defaults, overridden by configure()
        $this->map = $map;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replace specific property fetches with method calls',
            [
                new CodeSample(
                    <<<'PHP'
<?php

use App\Model\User;

class User
{
    public string $name;

    public function print(): void
    {
        echo $this->name;
    }
}
PHP,
                    <<<'PHP'
<?php

use App\Model\User;

class User
{
    public string $name;

    public function print(): void
    {
        echo $this->getName();
    }
}
PHP
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [PropertyFetch::class];
    }

    /**
     * @param PropertyFetch $node
     */
    public function refactor(Node $node): ?Node
    {
        $propertyName = $this->getName($node->name);
        if ($propertyName === null) {
            return null;
        }

        // Walk up the parent chain to find the containing class
        $parent = $node->getAttribute('parent');
        while ($parent instanceof Node && ! $parent instanceof Class_) {
            $parent = $parent->getAttribute('parent');
        }

        if (! $parent instanceof Class_) {
            // Not inside a class, nothing to do
            return null;
        }

        $className = $this->getName($parent);
        if ($className === null) {
            return null;
        }

        // Match against configured class => [property => method] map
        foreach ($this->map as $configuredClass => $propertyToMethod) {
            if ($className !== $configuredClass) {
                continue;
            }

            if (! isset($propertyToMethod[$propertyName])) {
                continue;
            }

            $methodName = $propertyToMethod[$propertyName];

            return new MethodCall(
                $node->var,
                $this->nodeFactory->createIdentifier($methodName)
            );
        }

        return null;
    }

    /**
     * Called by Rector when using rulesWithConfiguration().
     *
     * @param array<class-string, array<string, string>> $configuration
     */
    public function configure(array $configuration): void
    {
        $this->map = $configuration;
    }
}
