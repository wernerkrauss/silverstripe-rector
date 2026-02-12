<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\ORM;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\String_;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\ORM\ListSortToArrayRector\ListSortToArrayRectorTest
 */
class ListSortToArrayRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Code Style: Translates Silverstripe ORM sort() calls from string notation to array notation.',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
$list->sort('Title', 'DESC');
$list->sort('Title');
$list->sort('Title ASC, Created DESC');
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
$list->sort(['Title' => 'DESC']);
$list->sort(['Title' => 'ASC']);
$list->sort(['Title' => 'ASC', 'Created' => 'DESC']);
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
        if (!$this->isName($node->name, 'sort')) {
            return null;
        }

        if (!$this->isObjectType($node->var, new \PHPStan\Type\ObjectType('SilverStripe\ORM\DataList')) &&
            !$this->isObjectType($node->var, new \PHPStan\Type\ObjectType('SilverStripe\ORM\ArrayList'))
        ) {
            return null;
        }

        $argsCount = count($node->args);
        if ($argsCount === 0 || $argsCount > 2) {
            return null;
        }

        $arg0 = $node->args[0]->value;

        // If first arg is already an array, do nothing
        if ($arg0 instanceof Array_) {
            return null;
        }

        if ($argsCount === 2) {
            $arg1 = $node->args[1]->value;
            $array = new Array_([
                new ArrayItem($arg1, $arg0)
            ]);
            $node->args = [$this->nodeFactory->createArg($array)];
            return $node;
        }

        // argsCount === 1
        if (!$arg0 instanceof String_) {
            return null;
        }

        $sortString = $arg0->value;
        
        // Handle SQL functions or complex expressions - skip them
        if (strpos($sortString, '(') !== false || strpos($sortString, ')') !== false) {
            return null;
        }

        $parts = explode(',', $sortString);
        $items = [];
        foreach ($parts as $part) {
            $part = trim($part);
            if ($part === '') {
                continue;
            }

            $subParts = preg_split('/\s+/', $part);
            $field = $subParts[0];
            $direction = 'ASC';
            if (isset($subParts[1])) {
                $dir = strtoupper($subParts[1]);
                if (in_array($dir, ['ASC', 'DESC'])) {
                    $direction = $dir;
                }
            }
            
            $items[] = new ArrayItem(new String_($direction), new String_($field));
        }

        if ($items === []) {
            return null;
        }

        $node->args = [$this->nodeFactory->createArg(new Array_($items))];

        return $node;
    }
}
