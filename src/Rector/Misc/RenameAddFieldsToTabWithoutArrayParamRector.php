<?php

declare (strict_types=1);
namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PhpParser\Node\Name;
use Rector\Rector\AbstractRector;
use Rector\ValueObject\PhpVersionFeature;
use Rector\VersionBonding\Contract\MinPhpVersionInterface;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class RenameAddFieldsToTabWithoutArrayParamRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition() : RuleDefinition
    {
        return new RuleDefinition('Renames ->addFieldsToTab($name, $singleField) to ->addFieldToTab($name, $singleField)', [new CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function getCMSFields()
    {
        $time = mktime(1, 2, 3);
        $nextTime = mktime();
    }
}
CODE_SAMPLE
            , <<<'CODE_SAMPLE'
class SomeClass extends \SilverStripe\ORM\DataObject
{
    public function getCMSFields() {
        $myfield = FormField::create();
        $fields->addFieldToTab('Root.Main', $myfield);
    }
}
CODE_SAMPLE
        )]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [MethodCall::class, NullsafeMethodCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(Node $node) : ?Node
    {
        if (!$node->name === 'addFieldsToTab') {
            return null;
        }

        if ($node->args !== [] && $node->args[1]->value instanceof Node\Expr\Array_) {
            return null;
        }
        $node->name = new Name('addFieldToTab');
        return $node;
    }
}
