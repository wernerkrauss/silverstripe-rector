<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Control;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;
use SilverStripe\Control\Controller;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceHasCurrWithCurrRector\ReplaceHasCurrWithCurrRectorTest
 */
final class ReplaceHasCurrWithCurrRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 6.0: Replace Controller::has_curr() with Controller::curr() !== null',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
use SilverStripe\Control\Controller;
if (Controller::has_curr()) {
    // ...
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
use SilverStripe\Control\Controller;
if (Controller::curr() !== null) {
    // ...
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
        return [StaticCall::class, BooleanNot::class];
    }

    /**
     * @param StaticCall|BooleanNot $node
     */
    public function refactor(Node $node): ?Node
    {
        if ($node instanceof BooleanNot) {
            return $this->refactorBooleanNot($node);
        }

        return $this->refactorStaticCall($node);
    }

    private function refactorStaticCall(StaticCall $staticCall): ?Node
    {
        if (!$this->isObjectType($staticCall->class, new ObjectType(Controller::class))) {
            return null;
        }

        if (!$this->isName($staticCall->name, 'has_curr')) {
            return null;
        }

        $currStaticCall = new StaticCall($staticCall->class, 'curr');

        return new NotIdentical($currStaticCall, $this->nodeFactory->createNull());
    }

    private function refactorBooleanNot(BooleanNot $booleanNot): ?Node
    {
        if (!$booleanNot->expr instanceof StaticCall) {
            return null;
        }

        $staticCall = $booleanNot->expr;

        if (!$this->isObjectType($staticCall->class, new ObjectType(Controller::class))) {
            return null;
        }

        if (!$this->isName($staticCall->name, 'has_curr')) {
            return null;
        }

        $currStaticCall = new StaticCall($staticCall->class, 'curr');

        return new Identical($currStaticCall, $this->nodeFactory->createNull());
    }
}
