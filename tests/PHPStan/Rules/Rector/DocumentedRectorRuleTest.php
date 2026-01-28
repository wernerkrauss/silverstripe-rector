<?php

namespace Netwerkstatt\SilverstripeRector\Tests\PHPStan\Rules\Rector;

use PHPUnit\Framework\TestCase;

class DocumentedRectorRuleTest extends TestCase
{
    public function testRule()
    {
        $fixturesDir = __DIR__ . '/Fixture';
        $phpstanBin = 'vendor/bin/phpstan';
        
        // We need a temporary config that includes our rule and doesn't exclude the fixtures
        $tempConfig = tempnam(sys_get_temp_dir(), 'phpstan_test_') . '.neon';
        file_put_contents($tempConfig, "
parameters:
    level: 4
    bootstrapFiles:
        - " . realpath(__DIR__ . '/../../../../vendor/autoload.php') . "

rules:
    - Netwerkstatt\SilverstripeRector\PHPStan\Rules\Rector\DocumentedRectorRule
");

        $command = sprintf(
            '%s analyze %s --configuration=%s --error-format=json --no-progress',
            $phpstanBin,
            escapeshellarg($fixturesDir),
            escapeshellarg($tempConfig)
        );

        exec($command, $output, $returnCode);
        unlink($tempConfig);

        $json = implode('', $output);
        $result = json_decode($json, true);

        $this->assertIsArray($result, "PHPStan output is not valid JSON: " . $json);
        
        $filesWithErrors = $result['files'];
        
        // MissingInterfaceRector.php
        $missingInterfaceFile = realpath($fixturesDir . '/MissingInterfaceRector.php');
        $this->assertArrayHasKey($missingInterfaceFile, $filesWithErrors);
        $this->assertCount(1, $filesWithErrors[$missingInterfaceFile]['messages']);
        $this->assertStringContainsString(
            'must implement "Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface"',
            $filesWithErrors[$missingInterfaceFile]['messages'][0]['message']
        );

        // MissingConfiguredSampleRector.php
        $missingConfiguredFile = realpath($fixturesDir . '/MissingConfiguredSampleRector.php');
        $this->assertArrayHasKey($missingConfiguredFile, $filesWithErrors);
        $this->assertCount(1, $filesWithErrors[$missingConfiguredFile]['messages']);
        $this->assertStringContainsString(
            'must return "Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample" ' .
            'in "getRuleDefinition()"',
            $filesWithErrors[$missingConfiguredFile]['messages'][0]['message']
        );

        // Correct ones should NOT have errors
        $correctConfigurableFile = realpath($fixturesDir . '/CorrectConfigurableRector.php');
        $this->assertArrayNotHasKey($correctConfigurableFile, $filesWithErrors);

        $correctDocumentedFile = realpath($fixturesDir . '/CorrectDocumentedRector.php');
        $this->assertArrayNotHasKey($correctDocumentedFile, $filesWithErrors);
    }
}
