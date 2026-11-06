<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Forms;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\String_;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;
use Rector\RuleDoc\CodeSample\CodeSample;
use Rector\RuleDoc\Contract\DocumentedRuleInterface;
use Rector\RuleDoc\RuleDefinition;
use SilverStripe\Forms\FieldList;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\Forms\FieldListStringNameFirstRector\FieldListStringNameFirstRectorTest
 */
final class FieldListStringNameFirstRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 5.0: FieldList::insertAfter()/insertBefore() now take the field name (string) as the '
            . 'first argument and the field as the second. Calls with the old argument order are swapped.',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
$fields->insertAfter($myField, 'Title');
$fields->insertBefore($myField, 'Title');
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
$fields->insertAfter('Title', $myField);
$fields->insertBefore('Title', $myField);
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
        return [MethodCall::class];
    }

    /**
     * @param MethodCall $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isName($node->name, 'insertAfter') && !$this->isName($node->name, 'insertBefore')) {
            return null;
        }

        if (!$this->isObjectType($node->var, new ObjectType(FieldList::class))) {
            return null;
        }

        if (count($node->args) !== 2) {
            return null;
        }

        [$first, $second] = $node->args;
        if ($first->value instanceof String_ || !$second->value instanceof String_) {
            return null;
        }

        $node->args = [$second, $first];
        return $node;
    }
}
