<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Set;

final class SilverstripeSetList implements \Rector\Set\Contract\SetListInterface
{
    public const CODE_STYLE = __DIR__ . '/../../config/code-style.php';

    public const SS_4_0 = __DIR__ . '/../../config/silverstripe-4-0.php';
}