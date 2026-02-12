<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PhpParser\Node\Identifier;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class RenameAddFieldsToTabWithoutArrayParamRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 5.3: Renames ->addFieldsToTab($name, $singleField) to ->addFieldToTab($name, $singleField)',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
class SomeClass extends \SilverStripe\ORM\DataObject
{
    public function getCMSFields() {
        $myfield = FormField::create();
        $fields->addFieldsToTab('Root.Main', $myfield);
    }
}
CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
class SomeClass extends \SilverStripe\ORM\DataObject
{
    public function getCMSFields() {
        $myfield = FormField::create();
        $fields->addFieldToTab('Root.Main', $myfield);
    }
}
CODE_SAMPLE
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [MethodCall::class, NullsafeMethodCall::class];
    }

    /**
     * @param MethodCall|NullsafeMethodCall $node
     */
    public function refactor(Node $node): ?Node
    {
        // Only handle addFieldsToTab(...)
        if (! $this->isName($node->name, 'addFieldsToTab')) {
            return null;
        }

        // We need at least 2 args: ($tabName, $fieldOrFields)
        if (count($node->args) < 2) {
            return null;
        }

        // If the second argument is an array, keep as addFieldsToTab
        // (this rector is only for the *non-array* second arg case)
        $secondArgValue = $node->args[1]->value;
        if ($secondArgValue instanceof Array_) {
            return null;
        }

        // Change method name to addFieldToTab
        $node->name = new Identifier('addFieldToTab');
        return $node;
    }
}
