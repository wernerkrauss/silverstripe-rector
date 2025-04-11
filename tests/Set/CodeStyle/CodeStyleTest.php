<?php
declare(strict_types=1);
namespace Netwerkstatt\SilverstripeRector\Tests\Set\CodeStyle;

use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class CodeStyleTest extends AbstractRectorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function provideData(): \Iterator
    {
        if (class_exists(\SilverStripe\ORM\DataExtension::class)) {
            return self::yieldFilesFromDirectory(__DIR__ . '/Fixture');
        } else {
            return self::yieldFilesFromDirectory(__DIR__ . '/Fixture', '*.current.php.inc');
        }
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}
