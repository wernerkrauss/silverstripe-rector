<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\EnsureTableNameIsSetRector;

use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class EnsureTableNameIsSetRectorTest extends AbstractRectorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
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
