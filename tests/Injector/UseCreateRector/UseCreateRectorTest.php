<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\Injector\UseCreateRector;

use PHPUnit\Framework\Attributes\DataProvider;

class UseCreateRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        require_once __DIR__ . '/Source/InjectableClass.php';
        require_once __DIR__ . '/Source/InjectableSubClass.php';

        $this->doTestFile($filePath);
    }

    public static function provideData(): \Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}
