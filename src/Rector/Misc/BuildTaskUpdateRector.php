<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use Netwerkstatt\SilverstripeRector\Rector\Misc\BuildTaskUpdateRector\RequestToInputOptionVisitor;
use PhpParser\Modifiers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\VarLikeIdentifier;
use PhpParser\NodeTraverser;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Netwerkstatt\SilverstripeRector\Tests\Misc\BuildTaskUpdateRector\BuildTaskUpdateRectorTest
 */
final class BuildTaskUpdateRector extends AbstractRector implements DocumentedRuleInterface
{
    /**
     * @var PhpDocInfoFactory
     */
    protected $phpDocInfoFactory;

    public function __construct(PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Updates Silverstripe BuildTask from v5 to v6',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
use SilverStripe\Dev\BuildTask;

class MyTask extends BuildTask
{
    protected $title = 'My Task';

    public function run($request)
    {
        echo "Running task";
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
use SilverStripe\Dev\BuildTask;
use Symfony\Component\Console\Input\InputInterface;
use SilverStripe\PolyExecution\PolyOutput;

class MyTask extends BuildTask
{
    protected string $title = 'My Task';

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        $output->writeln('Running task');
        return \Symfony\Component\Console\Command\Command::SUCCESS;
    }
}
CODE_SAMPLE
                )
            ]
        );
    }

    public function getNodeTypes(): array
    {
        return [Class_::class];
    }

    /**
     * @param Class_ $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isObjectType($node, new ObjectType('SilverStripe\Dev\BuildTask')) &&
            !$this->isName($node->extends, 'SilverStripe\Dev\BuildTask') &&
            !$this->isName($node->extends, 'BuildTask')
        ) {
            return null;
        }

        $hasChanged = false;

        foreach ($node->getProperties() as $property) {
            if ($this->isName($property, 'segment')) {
                $property->props[0]->name = new VarLikeIdentifier('commandName');
                $property->type = new Identifier('string');
                $property->flags = Modifiers::PROTECTED | Modifiers::STATIC;
                $hasChanged = true;
            }

            if ($this->isName($property, 'title')) {
                $property->type = new Identifier('string');
                $property->flags = Modifiers::PROTECTED;
                $hasChanged = true;
            }

            if ($this->isName($property, 'description')) {
                $property->type = new Identifier('string');
                $property->flags = Modifiers::PROTECTED | Modifiers::STATIC;
                $hasChanged = true;
            }
        }

        $runMethod = $node->getMethod('run');
        if ($runMethod instanceof ClassMethod && $node->getMethod('execute') === null) {
            $runMethod->name = new Identifier('execute');
            $runMethod->flags = Modifiers::PROTECTED;
            $runMethod->returnType = new Identifier('int');

            $inputVarName = 'input';
            $outputVarName = 'output';

            $runMethod->params = [
                new Param(
                    new Variable($inputVarName),
                    null,
                    new FullyQualified('Symfony\Component\Console\Input\InputInterface')
                ),
                new Param(
                    new Variable($outputVarName),
                    null,
                    new FullyQualified('SilverStripe\PolyExecution\PolyOutput')
                ),
            ];

            $visitor = new RequestToInputOptionVisitor($inputVarName, $outputVarName);
            $traverser = new NodeTraverser();
            $traverser->addVisitor($visitor);
            /** @var Node\Stmt[] $stmts */
            $stmts = (array)$traverser->traverse((array)$runMethod->stmts);
            $runMethod->stmts = $stmts;

            $runMethod->stmts[] = new Return_(
                $this->nodeFactory->createClassConstFetch('Symfony\Component\Console\Command\Command', 'SUCCESS')
            );

            $options = $visitor->getOptions();
            if ($options !== []) {
                $node->stmts[] = $this->createGetOptionsMethod($options);
            }

            $hasChanged = true;
        }

        return $hasChanged ? $node : null;
    }

    private function createGetOptionsMethod(array $options): ClassMethod
    {
        $inputOptionClass = 'Symfony\Component\Console\Input\InputOption';
        $optionNodes = [];

        foreach ($options as $option) {
            $optionNodes[] = new ArrayItem(
                new New_(
                    new FullyQualified($inputOptionClass),
                    [
                        new Arg(new String_($option)),
                        new Arg($this->nodeFactory->createNull()),
                        new Arg($this->nodeFactory->createClassConstFetch($inputOptionClass, 'VALUE_NONE')),
                        new Arg(new String_('do something specific')), // Default description as in issue
                    ]
                )
            );
        }

        $method = new ClassMethod('getOptions');
        $method->flags = Modifiers::PUBLIC;
        $method->returnType = new Identifier('array');
        $method->stmts = [
            new Return_(new Array_($optionNodes))
        ];

        return $method;
    }
}
