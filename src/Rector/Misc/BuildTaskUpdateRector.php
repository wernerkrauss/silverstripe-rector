<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use Netwerkstatt\SilverstripeRector\Rector\Misc\BuildTaskUpdateRector\RequestToInputOptionVisitor;
use PhpParser\Modifiers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Concat;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
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
        // Skip classes not extending another
        if (! $node->extends instanceof Name) {
            return null;
        }

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

            // Transform DB::alteration_message() to $output->writeln()
            $stmts = $this->transformDBAlterationMessage($stmts, $outputVarName);

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

    /**
     * Transform DB::alteration_message() to $output->writeln() with appropriate tags
     */
    private function transformDBAlterationMessage(array $stmts, string $outputVarName): array
    {
        foreach ($stmts as $key => $stmt) {
            $stmts[$key] = $this->transformDBInNode($stmt, $outputVarName);
        }

        return $stmts;
    }

    /**
     * Recursively transform DB::alteration_message in nodes
     *
     * Recursion is necessary because DB::alteration_message calls can appear
     * nested inside control structures (if/else, try/catch, loops, etc.)
     * not just at the top level of the execute() method.
     */
    private function transformDBInNode(Node $node, string $outputVarName): Node
    {
        // Transform StaticCall to DB::alteration_message
        if ($node instanceof StaticCall) {
            if ($this->isDBAlterationMessage($node)) {
                return $this->createWritelnCall($node, $outputVarName);
            }
        }

        // Recursively process child nodes (needed for nested calls in if/try/catch/loops)
        foreach ($node->getSubNodeNames() as $subNodeName) {
            $subNode = $node->$subNodeName;

            if ($subNode instanceof Node) {
                $node->$subNodeName = $this->transformDBInNode($subNode, $outputVarName);
            } elseif (is_array($subNode)) {
                foreach ($subNode as $k => $item) {
                    if ($item instanceof Node) {
                        $subNode[$k] = $this->transformDBInNode($item, $outputVarName);
                    }
                }
                $node->$subNodeName = $subNode;
            }
        }

        return $node;
    }

    /**
     * Check if StaticCall is DB::alteration_message
     */
    private function isDBAlterationMessage(StaticCall $staticCall): bool
    {
        if (! $staticCall->name instanceof Identifier) {
            return false;
        }

        if ($staticCall->name->toString() !== 'alteration_message') {
            return false;
        }

        if ($staticCall->class instanceof Name) {
            $className = $staticCall->class->toString();
            return $className === 'DB' || $className === 'SilverStripe\\ORM\\DB';
        }

        return false;
    }

    /**
     * Create $output->writeln() call with appropriate tag
     *
     * Maps Silverstripe DB::alteration_message types to Symfony Console output tags:
     * - SS5: created, changed, repaired, obsolete, deleted, error (per DB.php @param doc)
     * - Symfony: error, info, comment, question (standard tags)
     *
     * Mapping rationale:
     * - error → error (exact match)
     * - created → info (success/positive action)
     * - changed/repaired → comment (modification/warning level)
     * - obsolete/deleted → comment (deprecation/removal notice)
     * - no type → plain text (no formatting)
     */
    private function createWritelnCall(StaticCall $staticCall, string $outputVarName): MethodCall
    {
        $args = $staticCall->args;
        $message = $args[0]->value ?? new String_('');
        $type = isset($args[1]) ? $args[1]->value : null;

        // Map Silverstripe alteration_message type to Symfony Console tag
        $tag = match (true) {
            $type instanceof String_ && $type->value === 'error' => 'error',
            $type instanceof String_ && $type->value === 'created' => 'info',
            $type instanceof String_ && in_array($type->value, ['changed', 'repaired', 'obsolete', 'deleted']) => 'comment',
            default => null,
        };

        // Wrap message with tag if needed
        if ($tag !== null && $message instanceof String_) {
            // Create new string with tags but preserve original string kind (single/double quotes)
            $newString = new String_("<{$tag}>{$message->value}</{$tag}>");
            $newString->setAttribute('kind', $message->getAttribute('kind', String_::KIND_SINGLE_QUOTED));
            $message = $newString;
        } elseif ($tag !== null) {
            // If message is not a simple string (e.g., variable), we need to concatenate
            $message = new Concat(
                new Concat(
                    new String_("<{$tag}>"),
                    $message
                ),
                new String_("</{$tag}>")
            );
        }
        // else: no tag, pass message as-is (preserves original quotes)

        return new MethodCall(
            new Variable($outputVarName),
            new Identifier('writeln'),
            [new Arg($message)]
        );
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
