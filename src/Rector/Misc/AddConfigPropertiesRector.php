<?php

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\Comments\NodeDocBlock\DocBlockUpdater;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Extensible;
use SilverStripe\ORM\DataObject;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class AddConfigPropertiesRector extends AbstractRector implements ConfigurableRectorInterface, DocumentedRuleInterface
{
    private PhpDocInfoFactory $phpDocInfoFactory;

    /**
     * @var \Rector\Comments\NodeDocBlock\DocBlockUpdater
     */
    private $docBlockUpdater;

    /**
     * @var array|mixed[]
     */
    private array $classConfigPairs = [];

    private array $defaultClassConfigPairs = [
        DataObject::class => [
            'table_name',
            'db',
            'has_one',
            'belongs_to',
            'has_many',
            'many_many',
            'many_many_extraFields',
            'belongs_many_many',
            'default_sort',
            'cascade_deletes',
            'cascade_duplicates',
            'searchable_fields',
            'summary_fields',
            'casting',
            'singular_name',
            'plural_name',
            'owns',
            'translate',
            'defaults',
            'extensions'
        ],
        Controller::class => [
            'allowed_actions',
            'url_handlers',
            'url_segment',
            'extensions'
        ],
        LeftAndMain::class => [
            'menu_icon',
            'menu_priority',
            'url_priority',
        ],
        ModelAdmin::class => [
            'managed_models',
            'page_length',
            'menu_title',
            'menu_icon_class',
        ],
        \SilverStripe\Core\Extension::class => [
            'allowed_actions',
            'url_handlers',
            'db',
            'has_one',
            'belongs_to',
            'has_many',
            'many_many',
            'many_many_extraFields',
            'belongs_many_many',
            'default_sort',
            'cascade_deletes',
            'cascade_duplicates',
            'searchable_fields',
            'summary_fields',
            'casting',
            'singular_name',
            'plural_name',
            'owns',
            'translate',
            'defaults',
            'required_fields'
        ],
        'SilverStripe\Dev\BuildTask' => [
            'segment',
            'title',
            'description',
            'is_enabled'
        ],
        'SilverStripe\CMS\Model\SiteTree' => [
            'icon'
        ],
        //Elemental
        'DNADesign\Elemental\Models\BaseElement' => [
            'icon',
            'inline_editable',
            'description'
        ],
    ];

    public function __construct(
        DocBlockUpdater $docBlockUpdater,
        PhpDocInfoFactory $phpDocInfoFactory
    ) {
        $this->docBlockUpdater = $docBlockUpdater;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }

    /**
     * @var bool
     */
    private bool $nodeIsChanged = false;

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Code Style: Adds @config property to predefined private statics, e.g. $db or $allowed_actions',
            [
                new ConfiguredCodeSample(
                    <<<'CODE_SAMPLE'
class SomeClass extends \SilverStripe\ORM\DataObject
{
    private static $db = [];
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
class SomeClass extends \SilverStripe\ORM\DataObject
{
    /**
    * @config
    */
    private static $db = [];
}
CODE_SAMPLE,
                    [
                        'ClassName' => [
                            'config_param'
                        ],
                    ]
                )
            ]
        );
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
        /** @var Class_ $node */
        $config = $this->getConfig();
        $this->nodeIsChanged = false;
        $propertiesToCheck = [];

        foreach ($config as $className => $configProperties) {
            if (!$this->isObjectType($node, new ObjectType($className))) {
                continue;
            }

            $propertiesToCheck = array_merge($propertiesToCheck, $configProperties);
        }

        if ($propertiesToCheck !== []) {
            $this->checkConfigProperties($node, array_unique($propertiesToCheck));
        }


        /** @phpstan-ignore ternary.alwaysFalse */
        return $this->nodeIsChanged ? $node : null;
    }

    private function getConfig(): array
    {
        $config = array_merge_recursive($this->defaultClassConfigPairs, $this->classConfigPairs);
        //loop through the config and remove duplicate entries in the arrays
        //caused by e.g. $db being in default config and in project's rector.php
        foreach ($config as $className => $configProperties) {
            $config[$className] = array_unique($configProperties);
        }

        return $config;
    }

    private function checkConfigProperties(Class_ $node, array $configProperties): Class_
    {
        foreach ($configProperties as $configProperty) {
            $property = $node->getProperty($configProperty);
            if (!$property instanceof \PhpParser\Node\Stmt\Property) {
                continue;
            }

            //check if it's a private static

            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
            if ($phpDocInfo->hasByName('config')) {
                continue;
            }

            $phpDocInfo->addPhpDocTagNode(new PhpDocTextNode('@config'));
            $this->docBlockUpdater->updateRefactoredNodeWithPhpDocInfo($property);

            $this->nodeIsChanged = true;
        }

        return $node;
    }

    public function configure(array $configuration): void
    {
        $this->classConfigPairs = $configuration;
    }
}
