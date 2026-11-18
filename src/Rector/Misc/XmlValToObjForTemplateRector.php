<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;
use Rector\RuleDoc\Contract\DocumentedRuleInterface;
use Rector\RuleDoc\CodeSample\CodeSample;
use Rector\RuleDoc\RuleDefinition;

/**
 * Silverstripe 5.4: ViewableData::XML_val() is deprecated and removed in 6.0.
 *
 * In 5.4 it was implemented as $this->obj($field, $arguments, $cache)->forTemplate(),
 * so the call is inlined like for like.
 *
 * @see \Netwerkstatt\SilverstripeRector\Tests\Misc\XmlValToObjForTemplateRector\XmlValToObjForTemplateRectorTest
 */
final class XmlValToObjForTemplateRector extends AbstractRector implements DocumentedRuleInterface
{
    /** @var string[] ViewableData was renamed to ModelData in 6.0; either may be present when this rule runs */
    private const TYPES = [
        \SilverStripe\View\ViewableData::class,
        'SilverStripe\\Model\\ModelData',
    ];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 5.4: Replace deprecated ViewableData::XML_val() with obj()->forTemplate()',
            [new CodeSample(
                '$value = $record->XML_val(\'Title\');',
                '$value = $record->obj(\'Title\')->forTemplate();'
            )]
        );
    }

    /** @return array<class-string<Node>> */
    public function getNodeTypes(): array
    {
        return [MethodCall::class];
    }

    /**
     * @param MethodCall $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isName($node->name, 'XML_val') || $node->isFirstClassCallable()) {
            return null;
        }

        if (!$this->isViewableData($node->var)) {
            return null;
        }

        // Arguments ($field, $arguments, $cache) map one to one onto obj()
        return new MethodCall(new MethodCall($node->var, 'obj', $node->args), 'forTemplate');
    }

    private function isViewableData(Node $node): bool
    {
        foreach (self::TYPES as $type) {
            if ($this->isObjectType($node, new ObjectType($type))) {
                return true;
            }
        }

        return false;
    }
}
