<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Type\ObjectType;
use Rector\PhpParser\Node\NodeFactory;
use Rector\Rector\AbstractRector;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Silverstripe 5.4: Replace deprecated null arguments with their explicit defaults.
 */
final class ReplaceSilverstripeNullArgumentRector extends AbstractRector implements
    ConfigurableRectorInterface,
    DocumentedRuleInterface
{
    /** @var list<array{class: string, method: string, position: int, replacement: mixed}> */
    private array $configuration = [];

    private NodeFactory $factory;

    public function __construct(NodeFactory $factory)
    {
        $this->factory = $factory;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 5.4: Replace deprecated null arguments with explicit defaults.',
            [new ConfiguredCodeSample(
                '$result->addError("Message", "bad", null, null);',
                '$result->addError("Message", "bad", "", ValidationResult::CAST_TEXT);',
                ['ValidationResult::addError' => ['position' => 2, 'replacement' => '']]
            )]
        );
    }

    public function getNodeTypes(): array
    {
        return [MethodCall::class, StaticCall::class];
    }

    public function configure(array $configuration): void
    {
        $this->configuration = $configuration;
    }

    public function refactor(Node $node): ?Node
    {
        if (!$node instanceof MethodCall && !$node instanceof StaticCall) {
            return null;
        }

        $changed = false;
        foreach ($this->configuration as $replacement) {
            $class = $replacement['class'];
            $method = $replacement['method'];
            if (!$this->isName($node->name, $method)) {
                continue;
            }

            $object = $node instanceof MethodCall ? $node->var : $node->class;
            if (!$this->isObjectType($object, new ObjectType($class))) {
                continue;
            }

            $argument = $node->args[$replacement['position']] ?? null;
            if ($argument === null || !$argument->value instanceof ConstFetch
                || !$this->isName($argument->value->name, 'null')) {
                continue;
            }

            $isClassConstant = is_string($replacement['replacement'])
                && strpos($replacement['replacement'], '::') !== false;
            $argument->value = $isClassConstant
                ? $this->factory->createClassConstFetch(...explode('::', $replacement['replacement'], 2))
                : $this->factory->createArg($replacement['replacement'])->value;
            $changed = true;
        }

        return $changed ? $node : null;
    }
}
