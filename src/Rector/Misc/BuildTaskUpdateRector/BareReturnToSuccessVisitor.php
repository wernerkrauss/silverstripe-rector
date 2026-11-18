<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc\BuildTaskUpdateRector;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeVisitor;
use PhpParser\NodeVisitorAbstract;

/**
 * Turns bare "return;" statements of a BuildTask::run() body into "return Command::SUCCESS;",
 * because execute() is declared with an int return type.
 *
 * Returns inside closures, arrow functions, nested functions and anonymous classes belong to
 * another scope and are left alone.
 */
class BareReturnToSuccessVisitor extends NodeVisitorAbstract
{
    public function enterNode(Node $node)
    {
        if ($node instanceof Closure || $node instanceof ArrowFunction
            || $node instanceof Function_ || $node instanceof Class_
        ) {
            return NodeVisitor::DONT_TRAVERSE_CHILDREN;
        }

        if ($node instanceof Return_ && !$node->expr instanceof \PhpParser\Node\Expr) {
            // SS5 tasks had no exit status, so SUCCESS is the neutral equivalent of a bare return
            $node->expr = new ClassConstFetch(
                new FullyQualified('Symfony\Component\Console\Command\Command'),
                'SUCCESS'
            );
        }

        return null;
    }
}
