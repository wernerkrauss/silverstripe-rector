<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use Rector\Rector\AbstractRector;
use Rector\RuleDoc\Contract\DocumentedRuleInterface;
use Rector\RuleDoc\CodeSample\CodeSample;
use Rector\RuleDoc\RuleDefinition;

/**
 * Silverstripe 5.4: Rename selected static APIs.
 *
 * SSViewer::fromString() and SSViewer::hasTemplate() are not plain renames: their replacements on
 * SSTemplateEngine are instance methods, and renderString() additionally needs a ViewLayerData model.
 * They are handled separately in refactorRenderWithFromString() and refactorHasTemplate().
 */
final class Silverstripe54StaticCallRenameRector extends AbstractRector implements DocumentedRuleInterface
{
    /** @var array<string, array{class: string, method: string}> */
    private const RENAMES = [
        'SilverStripe\\View\\SSViewer::flush' => [
            'class' => 'SilverStripe\\TemplateEngine\\SSTemplateEngine',
            'method' => 'flush',
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

    private const SSVIEWER = 'SilverStripe\\View\\SSViewer';

    private const TEMPLATE_ENGINE = 'SilverStripe\\TemplateEngine\\SSTemplateEngine';

    private const VIEW_LAYER_DATA = 'SilverStripe\\View\\ViewLayerData';

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 5.4: Rename selected static API calls.',
            [
                new CodeSample(
                    'SilverStripe\\View\\SSViewer::flush();',
                    'SilverStripe\\TemplateEngine\\SSTemplateEngine::flush();'
                ),
                new CodeSample(
                    '$html = $record->renderWith(SilverStripe\\View\\SSViewer::fromString($template));',
                    '$html = SilverStripe\\TemplateEngine\\SSTemplateEngine::create()->renderString($template, '
                    . 'SilverStripe\\View\\ViewLayerData::create($record));'
                ),
                new CodeSample(
                    'SilverStripe\\View\\SSViewer::hasTemplate($templates);',
                    'SilverStripe\\TemplateEngine\\SSTemplateEngine::create()->hasTemplate($templates);'
                ),
            ]
        );
    }

    /** @return array<class-string<Node>> */
    public function getNodeTypes(): array
    {
        return [MethodCall::class, StaticCall::class];
    }

    public function refactor(Node $node): ?Node
    {
        if ($node instanceof MethodCall) {
            return $this->refactorRenderWithFromString($node);
        }

        if (!$node instanceof StaticCall || !$node->name instanceof Identifier) {
            return null;
        }

        if ($this->isStaticCallTo($node, self::SSVIEWER, 'hasTemplate')) {
            return $this->refactorHasTemplate($node);
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

    /**
     * $record->renderWith(SSViewer::fromString($template))
     * -> SSTemplateEngine::create()->renderString($template, ViewLayerData::create($record))
     *
     * Only the plain single-argument forms are rewritten. Anything else (a second renderWith() argument,
     * the $cacheTemplate argument of fromString(), or fromString() used outside renderWith()) is left
     * untouched, so it surfaces as an undefined-method error instead of being rewritten into a call
     * that cannot work. Note that renderString() returns a string, while renderWith() returned DBHTMLText.
     */
    private function refactorRenderWithFromString(MethodCall $methodCall): ?Node
    {
        if (!$this->isName($methodCall->name, 'renderWith') || count($methodCall->args) !== 1) {
            return null;
        }

        $templateArg = $methodCall->args[0];
        if (!$templateArg instanceof Arg || !$templateArg->value instanceof StaticCall) {
            return null;
        }

        $fromString = $templateArg->value;
        if (!$this->isStaticCallTo($fromString, self::SSVIEWER, 'fromString') || count($fromString->args) !== 1
            || !$fromString->args[0] instanceof Arg
        ) {
            return null;
        }

        return new MethodCall(
            new StaticCall(new FullyQualified(self::TEMPLATE_ENGINE), 'create'),
            'renderString',
            [
                $fromString->args[0],
                new Arg(new StaticCall(
                    new FullyQualified(self::VIEW_LAYER_DATA),
                    'create',
                    [new Arg($methodCall->var)]
                )),
            ]
        );
    }

    /**
     * SSViewer::hasTemplate() was static, SSTemplateEngine::hasTemplate() is an instance method.
     */
    private function refactorHasTemplate(StaticCall $staticCall): Node
    {
        return new MethodCall(
            new StaticCall(new FullyQualified(self::TEMPLATE_ENGINE), 'create'),
            'hasTemplate',
            $staticCall->args
        );
    }

    private function isStaticCallTo(StaticCall $staticCall, string $class, string $method): bool
    {
        return $this->isName($staticCall->class, $class) && $this->isName($staticCall->name, $method);
    }
}
