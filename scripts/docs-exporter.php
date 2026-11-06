<?php

declare(strict_types=1);

use Rector\RuleDoc\Contract\CodeSampleInterface;
use Rector\RuleDoc\Contract\DocumentedRuleInterface;

require dirname(__DIR__) . '/vendor/autoload.php';

$sourceDirectory = dirname(__DIR__) . '/src/Rector';
$documentationFile = dirname(__DIR__) . '/docs/all_rectors_overview.md';
$projectRoot = dirname(__DIR__);
$format = $argv[1] ?? 'markdown';

$rules = [];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($sourceDirectory));

foreach ($iterator as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $relativePath = substr($file->getPathname(), strlen($sourceDirectory) + 1);
    $className = 'Netwerkstatt\\SilverstripeRector\\Rector\\' . str_replace(
        ['/', '.php'],
        ['\\', ''],
        $relativePath
    );

    if (!class_exists($className) || !is_a($className, DocumentedRuleInterface::class, true)) {
        continue;
    }

    $reflection = new ReflectionClass($className);
    if ($reflection->isAbstract() || strpos((string) $reflection->getDocComment(), '@deprecated') !== false) {
        continue;
    }

    /** @var DocumentedRuleInterface $rule */
    $rule = $reflection->newInstanceWithoutConstructor();
    $definition = $rule->getRuleDefinition();
    $relativeFilePath = str_replace('\\', '/', substr($file->getPathname(), strlen($projectRoot) + 1));

    $rules[] = [
        'name' => $reflection->getShortName(),
        'class' => $className,
        'description' => $definition->getDescription(),
        'file' => '../' . $relativeFilePath,
        'configurable' => $definition->isConfigurable(),
        'samples' => $definition->getCodeSamples(),
    ];
}

usort($rules, static function (array $first, array $second): int {
    return $first['name'] <=> $second['name'];
});

$setLists = collectSetLists($projectRoot);
$ruleSetMembership = [];
foreach ($setLists as $setList) {
    foreach ($setList['rules'] as $className) {
        $ruleSetMembership[$className][] = $setList['name'];
    }
}

$structuredRules = array_map(static function (array $rule) use ($ruleSetMembership): array {
    $category = null;
    $silverstripeVersion = null;
    if (preg_match('/^Code Style:/', $rule['description']) === 1) {
        $category = 'Code Style';
    } elseif (preg_match('/^Silverstripe ([0-9]+\.[0-9]+):/', $rule['description'], $matches) === 1) {
        $category = 'Silverstripe';
        $silverstripeVersion = $matches[1];
    } elseif (strpos($rule['description'], 'Silverstripe:') === 0) {
        $category = 'Silverstripe';
    }

    return [
        'name' => $rule['name'],
        'class' => $rule['class'],
        'category' => $category,
        'silverstripe_version_mentioned' => $silverstripeVersion,
        'set_versions' => array_values(array_filter(array_map(static function (string $setName): ?string {
            return preg_match('/^SS_([0-9]+)_([0-9]+)$/', $setName, $matches) === 1
                ? $matches[1] . '.' . $matches[2]
                : null;
        }, $ruleSetMembership[$rule['class']] ?? []))),
        'description' => $rule['description'],
        'file' => substr($rule['file'], 3),
        'configurable' => $rule['configurable'],
        'sets' => array_values(array_unique($ruleSetMembership[$rule['class']] ?? [])),
        'examples' => array_map(static function (CodeSampleInterface $sample): array {
            return [
                'before' => $sample->getBadCode(),
                'after' => $sample->getGoodCode(),
                'requires_configuration' => $sample instanceof ConfiguredCodeSample,
            ];
        }, $rule['samples']),
    ];
}, $rules);

if ($format === 'rules-json' || $format === 'json') {
    $outputFile = $format === 'rules-json'
        ? $projectRoot . '/docs/rector-rules.json'
        : $projectRoot . '/docs/rectors-and-setlists.json';
    $structuredData = ['schema_version' => 1, 'rules' => $structuredRules];
    if ($format === 'json') {
        $structuredData['setlists'] = $setLists;
    }

    $json = json_encode($structuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    if ($json === false || file_put_contents($outputFile, $json . "\n") === false) {
        fwrite(STDERR, sprintf("Unable to write structured documentation to %s\n", $outputFile));
        exit(1);
    }

    fwrite(STDOUT, sprintf("Generated structured documentation in %s\n", $outputFile));
    exit(0);
}

if ($format !== 'markdown') {
    fwrite(STDERR, "Usage: php scripts/docs-exporter.php [markdown|rules-json|json]\n");
    exit(2);
}

$lines = [
    sprintf('# %d Rules Overview', count($rules)),
    '',
    '<br>',
    '',
    '## Categories',
    '',
    sprintf('- [Rector](#rector) (%d)', count($rules)),
    '',
    '<br>',
    '',
    '## Rector',
    '',
];

foreach ($rules as $rule) {
    $lines[] = '### ' . $rule['name'];
    $lines[] = '';
    $lines[] = highlightDescription($rule['description']);
    $lines[] = '';

    if ($rule['configurable']) {
        $lines[] = ':wrench: **configure it!**';
        $lines[] = '';
    }

    $lines[] = sprintf('- class: [`%s`](%s)', $rule['class'], $rule['file']);
    $lines[] = '';

    foreach ($rule['samples'] as $sample) {
        if (!$sample instanceof CodeSampleInterface) {
            continue;
        }

        $lines[] = '```diff';
        $lines = array_merge($lines, createDiff($sample->getBadCode(), $sample->getGoodCode()));
        $lines[] = '```';

        $lines[] = '';
        $lines[] = '<br>';
        $lines[] = '';
    }
}

$content = implode("\n", $lines);
$content = rtrim($content) . "\n";

if (file_put_contents($documentationFile, $content) === false) {
    fwrite(STDERR, sprintf("Unable to write documentation to %s\n", $documentationFile));
    exit(1);
}

fwrite(STDOUT, sprintf("Generated %d Rector entries in %s\n", count($rules), $documentationFile));

/**
 * @return string[]
 */
function createDiff(string $before, string $after): array
{
    $beforeLines = explode("\n", trim(str_replace("\r\n", "\n", $before)));
    $afterLines = explode("\n", trim(str_replace("\r\n", "\n", $after)));
    $beforeCount = count($beforeLines);
    $afterCount = count($afterLines);
    $lcs = array_fill(0, $beforeCount + 1, array_fill(0, $afterCount + 1, 0));

    for ($beforeIndex = $beforeCount - 1; $beforeIndex >= 0; --$beforeIndex) {
        for ($afterIndex = $afterCount - 1; $afterIndex >= 0; --$afterIndex) {
            $lcs[$beforeIndex][$afterIndex] = $beforeLines[$beforeIndex] === $afterLines[$afterIndex]
                ? $lcs[$beforeIndex + 1][$afterIndex + 1] + 1
                : max($lcs[$beforeIndex + 1][$afterIndex], $lcs[$beforeIndex][$afterIndex + 1]);
        }
    }

    $diffLines = [sprintf('@@ -1,%d +1,%d @@', $beforeCount, $afterCount)];
    $beforeIndex = 0;
    $afterIndex = 0;

    while ($beforeIndex < $beforeCount || $afterIndex < $afterCount) {
        if (
            $beforeIndex < $beforeCount
            && $afterIndex < $afterCount
            && $beforeLines[$beforeIndex] === $afterLines[$afterIndex]
        ) {
            $diffLines[] = rtrim($beforeLines[$beforeIndex]) === ''
                ? ''
                : ' ' . rtrim($beforeLines[$beforeIndex]);
            ++$beforeIndex;
            ++$afterIndex;
            continue;
        }

        if (
            $afterIndex < $afterCount
            && ($beforeIndex === $beforeCount || $lcs[$beforeIndex][$afterIndex + 1] > $lcs[$beforeIndex + 1][$afterIndex])
        ) {
            $diffLines[] = '+' . rtrim($afterLines[$afterIndex]);
            ++$afterIndex;
            continue;
        }

        $diffLines[] = '-' . rtrim($beforeLines[$beforeIndex]);
        ++$beforeIndex;
    }

    return $diffLines;
}

function highlightDescription(string $description): string
{
    $words = explode(' ', $description);
    foreach ($words as $index => $word) {
        $wordWithoutPunctuation = preg_replace('/[,.;:]+$/', '', $word);
        $trailingPunctuation = substr($word, strlen($wordWithoutPunctuation));
        if ($wordWithoutPunctuation !== '' && shouldHighlightWord($wordWithoutPunctuation)) {
            $words[$index] = '`' . $wordWithoutPunctuation . '`' . $trailingPunctuation;
        }
    }

    return implode(' ', $words);
}

function shouldHighlightWord(string $word): bool
{
    if (preg_match('/(@\w+)$/', $word) === 1) {
        return true;
    }
    if (strpos($word, '`') === 0 || substr($word, -1) === '`') {
        return false;
    }
    if (preg_match('/\w+\(\)/', $word) === 1) {
        return true;
    }
    if (class_exists($word) || interface_exists($word) || trait_exists($word)) {
        return strpos($word, '\\') !== false || in_array($word, [Throwable::class, 'Exception'], true);
    }
    if ($word === 'composer.json') {
        return true;
    }
    if (preg_match('/^\$[A-Za-z_][A-Za-z0-9_>-]*(?:\(\))?[^\]]?$/', $word) === 1) {
        return true;
    }

    return preg_match('/[A-Za-z::\\\\>\-]+\(\)$/', $word) === 1;
}

/**
 * @return array<int, array{name: string, type: string, version: ?string, includes: string[], rules: string[], effective_version_sets: string[]}>
 */
function collectSetLists(string $projectRoot): array
{
    $setLists = [];
    $setFiles = [];
    $setClasses = [
        'Netwerkstatt\\SilverstripeRector\\Set\\SilverstripeSetList' => 'versioned',
        'Netwerkstatt\\SilverstripeRector\\Set\\SilverstripeLevelSetList' => 'cumulative',
    ];

    foreach ($setClasses as $className => $type) {
        $reflection = new ReflectionClass($className);
        foreach ($reflection->getConstants() as $name => $configPath) {
            $setFiles[$className][$name] = $configPath;
            $version = null;
            if (preg_match('/(?:SS_|UP_TO_SS_)([0-9]+)_([0-9]+)/', $name, $matches) === 1) {
                $version = $matches[1] . '.' . $matches[2];
            }

            $kind = $name === 'CODE_STYLE' ? 'code-style' : $type;
            $configData = inspectSetConfig($configPath, $setClasses, $setFiles);
            $setLists[$className][$name] = [
                'name' => $name,
                'type' => $kind,
                'version' => $version,
                'includes' => $configData['includes'],
                'rules' => $configData['rules'],
                'config_file' => substr(str_replace('\\', '/', $configPath), strlen($projectRoot) + 1),
            ];
        }
    }

    // Level set configuration files may refer to other constants in either set-list class.
    foreach ($setClasses as $className => $type) {
        foreach ($setFiles[$className] as $name => $configPath) {
            $configData = inspectSetConfig($configPath, $setClasses, $setFiles);
            $setLists[$className][$name]['includes'] = $configData['includes'];
            $setLists[$className][$name]['rules'] = $configData['rules'];
        }
    }

    $setsByName = [];
    foreach ($setLists as $sets) {
        foreach ($sets as $set) {
            $setsByName[$set['name']] = $set;
        }
    }
    foreach ($setLists as $className => $sets) {
        foreach ($sets as $name => $set) {
            $setLists[$className][$name]['effective_version_sets'] = $set['type'] === 'cumulative'
                ? resolveVersionSets($set['includes'], $setsByName)
                : [];
        }
    }

    $flattened = [];
    foreach ($setLists as $sets) {
        foreach ($sets as $set) {
            $flattened[] = $set;
        }
    }

    usort($flattened, static function (array $first, array $second): int {
        return $first['name'] <=> $second['name'];
    });

    return $flattened;
}

/**
 * @param string[] $includedSets
 * @param array<string, array{name: string, type: string, version: ?string, includes: string[], rules: string[]}> $setsByName
 * @return string[]
 */
function resolveVersionSets(array $includedSets, array $setsByName): array
{
    $resolved = [];
    foreach ($includedSets as $includedSetName) {
        if (!isset($setsByName[$includedSetName])) {
            continue;
        }
        $includedSet = $setsByName[$includedSetName];
        if ($includedSet['type'] === 'versioned') {
            $resolved[] = $includedSetName;
            continue;
        }
        $resolved = array_merge($resolved, resolveVersionSets($includedSet['includes'], $setsByName));
    }

    $resolved = array_values(array_unique($resolved));
    usort($resolved, static function (string $first, string $second) use ($setsByName): int {
        return version_compare(
            (string) $setsByName[$first]['version'],
            (string) $setsByName[$second]['version']
        );
    });

    return $resolved;
}

/**
 * @param array<string, string> $setClasses
 * @param array<string, array<string, string>> $setFiles
 * @return array{includes: string[], rules: string[]}
 */
function inspectSetConfig(string $configPath, array $setClasses, array $setFiles): array
{
    $contents = file_get_contents($configPath);
    if ($contents === false) {
        return ['includes' => [], 'rules' => []];
    }

    $imports = [];
    preg_match_all('/^use\s+([^;]+);/m', $contents, $useMatches);
    foreach ($useMatches[1] as $useName) {
        if (strpos($useName, ',') !== false || strpos($useName, '{') !== false) {
            continue;
        }
        $parts = preg_split('/\s+as\s+/i', trim($useName));
        $fullName = ltrim($parts[0], '\\');
        $aliasParts = explode('\\', $fullName);
        $imports[$parts[1] ?? end($aliasParts)] = $fullName;
    }

    $rules = [];
    preg_match_all('/->rule(?:WithConfiguration)?\s*\(\s*([A-Za-z_][A-Za-z0-9_]*)::class/s', $contents, $ruleMatches);
    foreach ($ruleMatches[1] as $name) {
        $rules[] = resolveImportedClass($name, $imports);
    }
    $rules = array_values(array_unique($rules));
    sort($rules);

    $includes = [];
    preg_match_all('/\b([A-Za-z_][A-Za-z0-9_]*)::([A-Z][A-Z0-9_]*)\b/', $contents, $setMatches, PREG_SET_ORDER);
    foreach ($setMatches as $setMatch) {
        $className = $imports[$setMatch[1]] ?? null;
        if (!isset($setClasses[$className])) {
            continue;
        }
        $includes[] = $setMatch[2];
    }
    $includes = array_values(array_unique($includes));
    sort($includes);

    return ['includes' => $includes, 'rules' => $rules];
}

/**
 * @param array<string, string> $imports
 */
function resolveImportedClass(string $name, array $imports): string
{
    $name = ltrim($name, '\\');
    $parts = explode('\\', $name);
    $alias = $parts[0];
    if (isset($imports[$alias])) {
        array_shift($parts);
        return $imports[$alias] . ($parts === [] ? '' : '\\' . implode('\\', $parts));
    }

    return $name;
}
