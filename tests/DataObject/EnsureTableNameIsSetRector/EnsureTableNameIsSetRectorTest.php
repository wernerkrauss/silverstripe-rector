<?php

declare(strict_types=1);

namespace Netwerkstatt\SilverstripeRector\Tests\DataObject\EnsureTableNameIsSetRector;

use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class EnsureTableNameIsSetRectorTest extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public function provideData(): \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}
