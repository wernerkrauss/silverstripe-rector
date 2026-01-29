<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc\BuildTaskUpdateRector;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\NodeVisitorAbstract;

class RequestToInputOptionVisitor extends NodeVisitorAbstract
{
    private array $options = [];

    private string $inputVariableName;

    private string $outputVariableName;

    public function __construct(string $inputVariableName, string $outputVariableName)
    {
        $this->inputVariableName = $inputVariableName;
        $this->outputVariableName = $outputVariableName;
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
            $this->options[$optionName] = $optionName;
            return new MethodCall(
                new Variable($this->inputVariableName),
                new Identifier('getOption'),
                [$node->args[0]]
            );
        }

        return null;
    }

    public function getOptions(): array
    {
        return array_values($this->options);
    }
}
