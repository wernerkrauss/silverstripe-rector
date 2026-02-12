<?php

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PHPStan\Type\ObjectType;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Replacement for the deprecated PropertyFetchToMethodCallRector.
 *
 * Configuration format:
 *
 * [
 *     Some\Class::class => [
 *         'propertyName' => 'methodName',
 *     ],
 * ]
 *
 * It matches by the class name or its children.
 */
final class PropertyFetchToMethodCallRector extends AbstractRector implements
    ConfigurableRectorInterface,
    DocumentedRuleInterface
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
            'Code Style: Replace specific property fetches with method calls',
            [
                new ConfiguredCodeSample(
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
PHP,
                    [
                        'ClassName' =>
                            ['propertyName' => 'methodName']
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

        foreach ($this->map as $configuredClass => $propertyToMethod) {
            if (!isset($propertyToMethod[$propertyName])) {
                continue;
            }

            if (!$this->isObjectType($node->var, new ObjectType($configuredClass))) {
                continue;
            }

            $methodName = $propertyToMethod[$propertyName];

            return new MethodCall(
                $node->var,
                $methodName
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
