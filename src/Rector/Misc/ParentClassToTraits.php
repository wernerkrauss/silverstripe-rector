<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Rector\Misc;

/**
 * Configuration: parent class + traits to add.
 *
 * Example:
 * new ParentClassToTraits(
 *     'Object',
 *     [
 *         'SilverStripe\Core\Injector\Injectable',
 *         'SilverStripe\Core\Config\Configurable',
 *         'SilverStripe\Core\Extensible',
 *     ]
 * );
 */
final class ParentClassToTraits
{
    private string $parentClass;

    /**
     * @var string[]
     */
    private array $traits;

    /**
     * @param string[] $traits
     */
    public function __construct(string $parentClass, array $traits)
    {
        $this->parentClass = $parentClass;
        $this->traits = $traits;
    }

    public function getParentClass(): string
    {
        return $this->parentClass;
    }

    /**
     * @return string[]
     */
    public function getTraits(): array
    {
        return $this->traits;
    }
}
