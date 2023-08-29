<?php
declare(strict_types=1);
namespace Netwerkstatt\SilverstripeRector\Tests\Set\CodeStyle;

use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

class CodeStyleTest extends AbstractRectorTestCase
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