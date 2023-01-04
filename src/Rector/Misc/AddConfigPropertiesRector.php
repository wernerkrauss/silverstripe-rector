<?php

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\DataObject;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class AddConfigPropertiesRector extends \Rector\Core\Rector\AbstractRector
{

    private PhpDocTypeChanger $phpDocTypeChanger;

    public function __construct(PhpDocTypeChanger $phpDocTypeChanger)
    {
        $this->phpDocTypeChanger = $phpDocTypeChanger;
    }

    /**
     * @var false
     */
    private bool $nodeIsChanged;

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Adds @config property to predefined private statics, e.g. $db or $allowed_actions',
            [
                new CodeSample(<<<'CODE_SAMPLE'
class SomeClass extends \SilverStripe\ORM\DataObject
{
    private static $db = [];
}
CODE_SAMPLE
                    , <<<'CODE_SAMPLE'
class SomeClass extends \SilverStripe\ORM\DataObject
{
    /**
    * @config
    */
    private static $db = [];
}
CODE_SAMPLE
                )
            ]);
    }

    /**
     * @inheritDoc
     */
    public function getNodeTypes(): array
    {
        return [Class_::class];
    }

    /**
     * @inheritDoc
     */
    public function refactor(Node $node): ?Node
    {
        $config = $this->getConfig();
        $this->nodeIsChanged = false;

        foreach ($config as $className => $configProperties) {
            if (!$this->isObjectType($node, new ObjectType($className))) {
                continue;
            }
            $node = $this->checkConfigProperties($node, $configProperties);
        }
        return $this->nodeIsChanged ? $node : null;
    }

    private function getConfig(): array
    {
        return [
            DataObject::class => [
                'db',
                'has_one',
                'belongs_to',
                'has_many',
                'many_many',
                'many_many_extraFields'
            ],
            Controller::class => [
                'allowed_actions'
            ]
        ];
    }

    private function checkConfigProperties(Node $node, array $configProperties): Node
    {
        foreach($configProperties as $configProperty) {
            $property = $node->getProperty($configProperty);
            if (!$property) {
                continue;
            }

            //check if it's a private static

            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
            if ($phpDocInfo->hasByName('@config')) {
                continue;
            }
            $phpDocInfo->addPhpDocTagNode(new PhpDocTextNode('@config'));

            if ($phpDocInfo->hasChanged()) {
                $this->nodeIsChanged = true;
            }
        }

        return $node;
    }

}