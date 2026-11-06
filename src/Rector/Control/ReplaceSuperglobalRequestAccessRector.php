<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Control;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Type\ObjectType;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\UnionType;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Rector\AbstractRector;
use Rector\RuleDoc\CodeSample\CodeSample;
use Rector\RuleDoc\CodeSample\ConfiguredCodeSample;
use Rector\RuleDoc\Contract\DocumentedRuleInterface;
use Rector\RuleDoc\RuleDefinition;
use SilverStripe\Control\Controller;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Core\Extension;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceSuperglobalRequestAccessRector\ReplaceSuperglobalRequestAccessRectorTest
 * @see \Netwerkstatt\SilverstripeRector\Tests\Control\ReplaceSuperglobalRequestAccessRectorWithCurrFallback\ReplaceSuperglobalRequestAccessRectorWithCurrFallbackTest
 */
final class ReplaceSuperglobalRequestAccessRector extends AbstractRector implements
    ConfigurableRectorInterface,
    DocumentedRuleInterface
{
    public const USE_CONTROLLER_CURR_FALLBACK = 'use_controller_curr_fallback';

    private bool $useControllerCurrFallback = false;

    /**
     * @param array<string, mixed> $configuration
     */
    public function configure(array $configuration): void
    {
        $this->useControllerCurrFallback = (bool) ($configuration[self::USE_CONTROLLER_CURR_FALLBACK] ?? false);
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Silverstripe 6.0: Replace $_GET and $_POST superglobal access with HTTPRequest::getVar()/postVar()',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
use SilverStripe\Control\Controller;

class MyController extends Controller
{
    public function index()
    {
        $foo = $_GET['foo'];
        $bar = $_POST['bar'];
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
use SilverStripe\Control\Controller;

class MyController extends Controller
{
    public function index()
    {
        $foo = $this->getRequest()->getVar('foo');
        $bar = $this->getRequest()->postVar('bar');
    }
}
CODE_SAMPLE
                ),
                new ConfiguredCodeSample(
                    <<<'CODE_SAMPLE'
use SilverStripe\Control\Controller;

class SomeService
{
    public function handle()
    {
        return $_GET['foo'];
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
use SilverStripe\Control\Controller;

class SomeService
{
    public function handle()
    {
        return \SilverStripe\Control\Controller::curr()?->getRequest()->getVar('foo');
    }
}
CODE_SAMPLE
                    ,
                    [self::USE_CONTROLLER_CURR_FALLBACK => true]
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [ArrayDimFetch::class];
    }

    /**
     * @param ArrayDimFetch $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$node->var instanceof Variable) {
            return null;
        }

        $variableName = $this->getName($node->var);
        if ($variableName !== '_GET' && $variableName !== '_POST') {
            return null;
        }

        if (!$node->dim instanceof String_) {
            return null;
        }

        $receiver = $this->resolveRequestReceiver($node);
        if (!$receiver instanceof Expr) {
            return null;
        }

        $methodName = $variableName === '_GET' ? 'getVar' : 'postVar';

        return new MethodCall($receiver, $methodName, [new Arg($node->dim)]);
    }

    private function resolveRequestReceiver(ArrayDimFetch $node): ?Expr
    {
        $scope = $node->getAttribute(AttributeKey::SCOPE);
        if (!$scope instanceof Scope) {
            return null;
        }

        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof ClassReflection) {
            return $this->useControllerCurrFallback ? $this->createCurrFallbackReceiver() : null;
        }

        if ($classReflection->getName() === RequestHandler::class
            || $classReflection->isSubclassOf(RequestHandler::class)
        ) {
            return new MethodCall(new Variable('this'), 'getRequest');
        }

        if ($classReflection->isSubclassOf(Extension::class)
            && $this->ownerIsRequestHandler($classReflection, $scope)
        ) {
            return new MethodCall(new MethodCall(new Variable('this'), 'getOwner'), 'getRequest');
        }

        return $this->useControllerCurrFallback ? $this->createCurrFallbackReceiver() : null;
    }

    private function ownerIsRequestHandler(ClassReflection $classReflection, Scope $scope): bool
    {
        if (!$classReflection->hasProperty('owner')) {
            return false;
        }

        $ownerType = TypeCombinator::removeNull($classReflection->getProperty('owner', $scope)->getReadableType());

        $types = $ownerType instanceof UnionType ? $ownerType->getTypes() : [$ownerType];
        foreach ($types as $type) {
            if ($type instanceof ObjectType && is_a($type->getClassName(), RequestHandler::class, true)) {
                return true;
            }
        }

        return false;
    }

    private function createCurrFallbackReceiver(): Expr
    {
        return new NullsafeMethodCall(new StaticCall(new FullyQualified(Controller::class), 'curr'), 'getRequest');
    }
}
