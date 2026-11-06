<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Forms;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;
use SilverStripe\Control\Director;
use Rector\RuleDoc\Contract\DocumentedRuleInterface;
use Rector\RuleDoc\CodeSample\CodeSample;
use Rector\RuleDoc\RuleDefinition;

/**
 * Silverstripe 5.4: Move selected instance calls to their new static APIs.
 */
final class Silverstripe54MethodCallToStaticCallRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 5.4: Move deprecated instance calls to their static replacements.',
            [new CodeSample(
                <<<'PHP'
$emails->isValidEmail($email);
$handler->isCli();
PHP,
                <<<'PHP'
\SilverStripe\Control\Email\Email::is_valid_address($email);
\SilverStripe\Control\Director::is_cli();
PHP
            )]
        );
    }

    /** @return array<class-string<Node>> */
    public function getNodeTypes(): array
    {
        return [MethodCall::class];
    }

    public function refactor(Node $node): ?Node
    {
        if (!$node instanceof MethodCall) {
            return null;
        }

        if ($this->isName($node->name, 'isValidEmail')
            && $this->isObjectType(
                $node->var,
                new ObjectType('SilverStripe\\ContentReview\\Tasks\\ContentReviewEmails')
            )) {
            return new StaticCall(
                new Node\Name\FullyQualified('SilverStripe\\Control\\Email\\Email'),
                'is_valid_address',
                $node->args
            );
        }

        if ($this->isName($node->name, 'isCli')
            && ($this->isObjectType($node->var, new ObjectType(\SilverStripe\Logging\HTTPOutputHandler::class))
                || $this->isObjectType($node->var, new ObjectType('SilverStripe\\Logging\\ErrorOutputHandler')))
        ) {
            return new StaticCall(
                new Node\Name\FullyQualified(Director::class),
                'is_cli'
            );
        }

        return null;
    }
}
