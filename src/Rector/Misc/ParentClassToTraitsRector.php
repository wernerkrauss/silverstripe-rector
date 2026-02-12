<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\TraitUse;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Replacement for ParentClassToTraitsRector.
 *
 * For each configured parent:
 *   class MyClass extends Object {}
 * becomes
 *   use SilverStripe\Core\Injector\Injectable;
 *   use SilverStripe\Core\Config\Configurable;
 *   use SilverStripe\Core\Extensible;
 *
 *   class MyClass
 *   {
 *       use Injectable, Configurable, Extensible;
 *   }
 */
final class ParentClassToTraitsRector extends AbstractRector implements
    ConfigurableRectorInterface,
    DocumentedRuleInterface
{
    /**
     * @var ParentClassToTraits[]
     */
    private array $configurations = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 4.0: Replace specific parent classes with traits and remove extends',
            [
                new ConfiguredCodeSample(
                    <<<'PHP'
<?php

class MyObject extends Object
{
}
PHP,
                    <<<'PHP'
<?php

use SilverStripe\Core\Injector\Injectable;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Extensible;

class MyObject
{
    use Injectable;
    use Configurable;
    use Extensible;
}
PHP,
                    ['Trait1','Trait2']
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
        if (! $node->extends instanceof Name) {
            return null;
        }

        foreach ($this->configurations as $configuration) {
            $parentClass = $configuration->getParentClass();

            // Works with 'Object', 'SS_Object', and FQCNs
            if (! $this->isName($node->extends, $parentClass)) {
                continue;
            }

            $traits = $configuration->getTraits();
            if ($traits === []) {
                continue;
            }

            // Remove extends
            $node->extends = null;

            // Collect already-used traits to avoid duplicates
            $existingTraitFqns = [];
            foreach ($node->stmts as $stmt) {
                if (! $stmt instanceof TraitUse) {
                    continue;
                }

                foreach ($stmt->traits as $traitName) {
                    $existingTraitFqns[] = $this->getName($traitName);
                }
            }

            $newTraitNames = [];
            foreach ($traits as $traitFqn) {
                if (in_array($traitFqn, $existingTraitFqns, true)) {
                    continue;
                }

                $newTraitNames[] = new Name\FullyQualified($traitFqn);
            }

            if ($newTraitNames !== []) {
                // Add a single "use" statement with all new traits at the top of the class body
                array_unshift($node->stmts, new TraitUse($newTraitNames));
            }

            return $node;
        }

        return null;
    }

    /**
     * @param ParentClassToTraits[] $configuration
     */
    public function configure(array $configuration): void
    {
        $this->configurations = $configuration;
    }
}
