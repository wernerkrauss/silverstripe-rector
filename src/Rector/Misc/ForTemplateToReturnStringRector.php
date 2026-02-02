<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Identifier;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;

final class ForTemplateToReturnStringRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Add string return type to forTemplate() methods',
            [
                new CodeSample(
                    <<<'CODE'
class Example {
    public function forTemplate() {
        return 'foo';
    }
}
CODE
                    ,
                    <<<'CODE'
class Example {
    public function forTemplate(): string {
        return 'foo';
    }
}
CODE
                ),
            ]
        );
    }

    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    public function refactor(Node $node): ?Node
    {
        /** @var ClassMethod $node */
        if (! $this->isName($node, 'forTemplate')) {
            return null;
        }

        // Skip if return type already exists
        if ($node->returnType !== null) {
            return null;
        }

        $node->returnType = new Identifier('string');

        return $node;
    }
}
