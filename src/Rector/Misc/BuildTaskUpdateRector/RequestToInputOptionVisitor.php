<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc\BuildTaskUpdateRector;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Do_;
use PhpParser\Node\Stmt\ElseIf_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\While_;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\NodeVisitorAbstract;

class RequestToInputOptionVisitor extends NodeVisitorAbstract
{
    private const BOOLEAN_CONTEXT_ATTRIBUTE = 'silverstripe_rector_boolean_context';

    /**
     * Option name => true if every getVar() call for it is only used as a condition (a flag)
     *
     * @var array<string, bool>
     */
    private array $options = [];

    private string $inputVariableName;

    private string $outputVariableName;

    public function __construct(string $inputVariableName, string $outputVariableName)
    {
        $this->inputVariableName = $inputVariableName;
        $this->outputVariableName = $outputVariableName;
    }

    /**
     * Mark expressions that are only evaluated for their truthiness, so getVar() calls used there
     * can become VALUE_NONE flags while any other usage keeps its value (VALUE_OPTIONAL).
     */
    public function enterNode(Node $node)
    {
        $conditions = [];
        if ($node instanceof If_ || $node instanceof ElseIf_ || $node instanceof While_ || $node instanceof Do_) {
            $conditions[] = $node->cond;
        } elseif ($node instanceof Ternary) {
            $conditions[] = $node->cond;
        } elseif ($node instanceof BooleanNot || $node instanceof Bool_) {
            $conditions[] = $node->expr;
        } elseif ($node instanceof BinaryOp\BooleanAnd || $node instanceof BinaryOp\BooleanOr
            || $node instanceof BinaryOp\LogicalAnd || $node instanceof BinaryOp\LogicalOr
            || $node instanceof BinaryOp\LogicalXor
        ) {
            $conditions[] = $node->left;
            $conditions[] = $node->right;
        }

        foreach ($conditions as $condition) {
            $condition->setAttribute(self::BOOLEAN_CONTEXT_ATTRIBUTE, true);
        }

        return null;
    }

    public function leaveNode(Node $node)
    {
        // echo "something" -> $output->writeln('something')
        if ($node instanceof Node\Stmt\Echo_) {
            $value = null;
            if (count($node->exprs) === 1 && $node->exprs[0] instanceof String_) {
                $value = $node->exprs[0]->value;
                $value = str_replace(["\n", "<br>", "<br/>", "<br />"], '', $value);
            }

            if ($value !== null) {
                return new Expression(
                    new MethodCall(
                        new Variable($this->outputVariableName),
                        new Identifier('writeln'),
                        [new Arg(new String_($value))]
                    )
                );
            }
        }

        // $request->getVar('foo') -> $input->getOption('foo')
        if ($node instanceof MethodCall && $node->var instanceof Variable && $node->name instanceof Identifier
            && ($node->name->toString() === 'getVar' && count($node->args) >= 1
                && $node->args[0]->value instanceof String_)
        ) {
            $optionName = $node->args[0]->value->value;
            $isFlag = $node->getAttribute(self::BOOLEAN_CONTEXT_ATTRIBUTE) === true;
            $this->options[$optionName] = ($this->options[$optionName] ?? true) && $isFlag;
            return new MethodCall(
                new Variable($this->inputVariableName),
                new Identifier('getOption'),
                [$node->args[0]]
            );
        }

        return null;
    }

    /**
     * @return string[]
     */
    public function getOptions(): array
    {
        return array_keys($this->options);
    }

    /**
     * Whether the option is only ever used as a condition, i.e. a value-less flag like ?run=1
     */
    public function isFlagOption(string $optionName): bool
    {
        return $this->options[$optionName] ?? false;
    }
}
