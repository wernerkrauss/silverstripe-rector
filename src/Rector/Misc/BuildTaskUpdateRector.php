<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\VarLikeIdentifier;
use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
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
use Symfony\Component\Console\Output\OutputInterface;

class MyTask extends BuildTask
{
    protected $description = 'My Task';

    /**
     * @todo Check if input/output needs manual migration.
     * @todo Define input parameters in getOptions() if needed.
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        echo "Running task";
    }
}
CODE_SAMPLE
                )
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
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
            if ($this->isName($property, 'title')) {
                $property->props[0]->name = new Node\VarLikeIdentifier('description');
                $hasChanged = true;
            }
        }

        $runMethod = $node->getMethod('run');
        if ($runMethod instanceof ClassMethod) {
            $runMethod->name = new Identifier('execute');
            
            $runMethod->params = [
                new Param(
                    new Variable('input'),
                    null,
                    new FullyQualified('Symfony\Component\Console\Input\InputInterface')
                ),
                new Param(
                    new Variable('output'),
                    null,
                    new FullyQualified('Symfony\Component\Console\Output\OutputInterface')
                ),
            ];

            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($runMethod);
            $phpDocInfo->addPhpDocTagNode(new PhpDocTagNode(
                '@todo',
                new GenericTagValueNode('Check if input/output needs manual migration.')
            ));
            $phpDocInfo->addPhpDocTagNode(new PhpDocTagNode(
                '@todo',
                new GenericTagValueNode('Define input parameters in getOptions() if needed.')
            ));

            $hasChanged = true;
        }

        return $hasChanged ? $node : null;
    }
}
