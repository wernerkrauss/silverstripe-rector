<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use Rector\Rector\AbstractRector;
use Rector\RuleDoc\Contract\DocumentedRuleInterface;
use Rector\RuleDoc\CodeSample\CodeSample;
use Rector\RuleDoc\RuleDefinition;

/**
 * Silverstripe 5.4: Rename selected static APIs.
 */
final class Silverstripe54StaticCallRenameRector extends AbstractRector implements DocumentedRuleInterface
{
    /** @var array<string, array{class: string, method: string}> */
    private const RENAMES = [
        'SilverStripe\\View\\SSViewer::flush' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'flush',
        ],
        'SilverStripe\\View\\SSViewer::fromString' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'renderString',
        ],
        'SilverStripe\\View\\SSViewer::setTemplate' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'setTemplate',
        ],
        'SilverStripe\\View\\SSViewer::setParser' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'setParser',
        ],
        'SilverStripe\\View\\SSViewer::getParser' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'getParser',
        ],
        'SilverStripe\\View\\SSViewer::hasTemplate' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'hasTemplate',
        ],
        'SilverStripe\\View\\SSViewer::flush_template_cache' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'flushTemplateCache',
        ],
        'SilverStripe\\View\\SSViewer::flush_cacheblock_cache' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'flushCacheBlockCache',
        ],
        'SilverStripe\\View\\SSViewer::setPartialCacheStore' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'setPartialCacheStore',
        ],
        'SilverStripe\\View\\SSViewer::getPartialCacheStore' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'getPartialCacheStore',
        ],
        'SilverStripe\\View\\SSViewer::includeGeneratedTemplate' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'includeGeneratedTemplate',
        ],
        'SilverStripe\\View\\SSViewer::getSubtemplateFor' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'getSubtemplateFor',
        ],
        'SilverStripe\\View\\SSViewer::parseTemplateContent' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'parseTemplateContent',
        ],
        \SilverStripe\ORM\FieldType\DBEnum::class . '::flushCache' => [
            'class' => \SilverStripe\ORM\FieldType\DBEnum::class,
            'method' => 'reset',
        ],
    ];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 5.4: Rename selected static API calls.',
            [new CodeSample(
                'SilverStripe\\View\\SSViewer::fromString($template);',
                'SilverStripe\\TemplateEngine\\SSTemplateEngine::renderString($template);'
            )]
        );
    }

    /** @return array<class-string<Node>> */
    public function getNodeTypes(): array
    {
        return [StaticCall::class];
    }

    public function refactor(Node $node): ?Node
    {
        if (!$node instanceof StaticCall || !$node->name instanceof Identifier) {
            return null;
        }

        $oldClass = $this->getName($node->class);
        $oldMethod = $this->getName($node->name);
        if ($oldClass === null || $oldMethod === null) {
            return null;
        }

        $rename = self::RENAMES[$oldClass . '::' . $oldMethod] ?? null;
        if ($rename === null) {
            return null;
        }

        $node->class = new FullyQualified($rename['class']);
        $node->name = new Identifier($rename['method']);

        return $node;
    }
}
