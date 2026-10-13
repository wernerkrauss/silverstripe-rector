<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Forms;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BinaryOp\Equal;
use PhpParser\Node\Expr\BinaryOp\NotEqual;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\BinaryOp\BooleanXor;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt\Do_;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\While_;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class FormValidateToIsValidRector extends AbstractRector implements DocumentedRuleInterface
{
    private bool $hasChanged = false;

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 6.0: Convert Form::validate() boolean usage to isValid().',
            [new CodeSample(
                <<<'PHP'
use SilverStripe\Forms\Form;

function check(Form $form, bool $other): bool
{
    if ($form->validate()) {
        return true;
    }

    return $form->validate() && $other;
}
PHP,
                <<<'PHP'
use SilverStripe\Forms\Form;

function check(Form $form, bool $other): bool
{
    if ($form->validate()->isValid()) {
        return true;
    }

    return $form->validate()->isValid() && $other;
}
PHP
            )]
        );
    }

    /** @return array<class-string<Node>> */
    public function getNodeTypes(): array
    {
        return [If_::class, While_::class, Do_::class, For_::class, BooleanAnd::class, BooleanOr::class,
            BooleanNot::class, Ternary::class, Identical::class, NotIdentical::class, Equal::class, NotEqual::class];
    }

    public function refactor(Node $node): ?Node
    {
        $this->hasChanged = false;
        if ($node instanceof If_ || $node instanceof While_ || $node instanceof Do_) {
            $node->cond = $this->refactorExpression($node->cond);
            return $this->hasChanged ? $node : null;
        }

        if ($node instanceof For_) {
            foreach ($node->cond as $key => $condition) {
                $node->cond[$key] = $this->refactorExpression($condition);
            }

            return $this->hasChanged ? $node : null;
        }

        if ($node instanceof BooleanAnd || $node instanceof BooleanOr) {
            $node->left = $this->refactorExpression($node->left);
            $node->right = $this->refactorExpression($node->right);
            return $this->hasChanged ? $node : null;
        }

        if ($node instanceof BooleanNot) {
            $node->expr = $this->refactorExpression($node->expr);
            return $this->hasChanged ? $node : null;
        }

        if ($node instanceof Ternary) {
            $node->cond = $this->refactorExpression($node->cond);
            return $this->hasChanged ? $node : null;
        }

        if ($node instanceof Identical || $node instanceof NotIdentical || $node instanceof Equal
            || $node instanceof NotEqual
        ) {
            if ($this->containsBooleanLiteral($node)) {
                $node->left = $this->refactorExpression($node->left);
                $node->right = $this->refactorExpression($node->right);
            }

            return $this->hasChanged ? $node : null;
        }

        return null;
    }

    private function containsBooleanLiteral(BinaryOp $node): bool
    {
        return ($node->left instanceof ConstFetch && $this->isBooleanName($node->left))
            || ($node->right instanceof ConstFetch && $this->isBooleanName($node->right));
    }

    private function isBooleanName(ConstFetch $node): bool
    {
        return $this->isName($node->name, 'true') || $this->isName($node->name, 'false');
    }

    /** @phpstan-impure */
    private function refactorExpression(Expr $expression): Expr
    {
        if ($expression instanceof MethodCall && $this->isName($expression->name, 'validate')
            && ($this->isObjectType($expression->var, new ObjectType('SilverStripe\\Forms\\Form'))
                || $this->isObjectType($expression->var, new ObjectType(\SilverStripe\Forms\FormField::class)))
        ) {
            $this->hasChanged = true;
            $validateCall = clone $expression;
            $validateCall->args = [];
            return new MethodCall($validateCall, 'isValid');
        }

        if ($expression instanceof BooleanAnd || $expression instanceof BooleanOr) {
            $expression->left = $this->refactorExpression($expression->left);
            $expression->right = $this->refactorExpression($expression->right);
        }

        if ($expression instanceof BooleanNot) {
            $expression->expr = $this->refactorExpression($expression->expr);
        }

        return $expression;
    }
}
