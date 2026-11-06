<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Forms;

use PhpParser\Node;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\LNumber;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;
use Rector\RuleDoc\Contract\DocumentedRuleInterface;
use Rector\RuleDoc\CodeSample\CodeSample;
use Rector\RuleDoc\RuleDefinition;

/**
 * Silverstripe 5.4: Replace legacy Form::loadDataFrom() merge strategy booleans.
 */
final class FormLoadDataFromMergeStrategyRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 5.4: Replace Form::loadDataFrom() merge strategy booleans with explicit values.',
            [new CodeSample(
                <<<'PHP'
use SilverStripe\Forms\Form;

$form->loadDataFrom($data, true);
$form->loadDataFrom($data, false);
PHP,
                <<<'PHP'
use SilverStripe\Forms\Form;

$form->loadDataFrom($data, \SilverStripe\Forms\Form::MERGE_CLEAR_MISSING);
$form->loadDataFrom($data, 0);
PHP
            )]
        );
    }

    /** @return array<class-string<Node>> */
    public function getNodeTypes(): array
    {
        return [MethodCall::class];
    }

    public function refactor(Node $node): ?Node
    {
        if (!$node instanceof MethodCall || !$this->isName($node->name, 'loadDataFrom')
            || !$this->isObjectType($node->var, new ObjectType('SilverStripe\\Forms\\Form'))) {
            return null;
        }

        $argument = $node->args[1] ?? null;
        if ($argument === null || !$argument->value instanceof ConstFetch) {
            return null;
        }

        if ($this->isName($argument->value->name, 'true')) {
            $argument->value = $this->nodeFactory->createClassConstFetch(
                'SilverStripe\\Forms\\Form',
                'MERGE_CLEAR_MISSING'
            );
            return $node;
        }

        if ($this->isName($argument->value->name, 'false')) {
            $argument->value = new LNumber(0);
            return $node;
        }

        return null;
    }
}
