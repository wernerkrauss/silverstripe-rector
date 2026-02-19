<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/scripts'
    ]);
    $rectorConfig->autoloadPaths([
    ]);


//    // define sets of rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_74,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE
    ]);

};
