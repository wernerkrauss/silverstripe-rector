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

final class RenameFieldListMethodsWithoutArrayParamRector extends AbstractRector implements DocumentedRuleInterface
{
    private const METHOD_MAP = [
        'addFieldsToTab' => 'addFieldToTab',
        'removeFieldsFromTab' => 'removeFieldFromTab',
    ];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 5.3: Renames FieldList plural methods to singular if second argument is not an array',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
$fields->addFieldsToTab('Root.Main', $myfield);
$fields->removeFieldsFromTab('Root.Main', $myfield);
CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
$fields->addFieldToTab('Root.Main', $myfield);
$fields->removeFieldFromTab('Root.Main', $myfield);
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
        $methodName = $this->getName($node->name);
        if ($methodName === null || ! isset(self::METHOD_MAP[$methodName])) {
            return null;
        }

        // We need at least 2 args: ($tabName, $fieldOrFields)
        if (count($node->args) < 2) {
            return null;
        }

        // If the second argument is an array, keep plural method name
        $secondArgValue = $node->args[1]->value;
        if ($secondArgValue instanceof Array_) {
            return null;
        }

        // Change method name to singular version
        $node->name = new Identifier(self::METHOD_MAP[$methodName]);
        return $node;
    }
}
