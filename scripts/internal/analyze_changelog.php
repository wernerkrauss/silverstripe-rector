<?php
/**
 * Analyze Silverstripe changelog HTML and generate a Markdown TODO list.
 * Internal script for ddev changelog-analyze.
 */

declare(strict_types=1);

if (!isset($argv[1])) {
    fwrite(STDERR, "Usage: php analyze_changelog.php <html_file>\n");
    exit(1);
}

$htmlFile = $argv[1];
if (!file_exists($htmlFile)) {
    fwrite(STDERR, sprintf("File not found: %s%s", $htmlFile, PHP_EOL));
    exit(1);
}

$version = basename($htmlFile, '.html');
$version = str_replace('ss-', '', $version);
$html = file_get_contents($htmlFile) ?: '';

// Extract the "API changes" section
// Try multiple patterns; some older docs might not have the id attribute
$sectionMatch = false;
$sectionContent = '';
if (preg_match('/<h2 id="api-changes">\s*API changes.*?<\/h2>(.*?)<h2/si', $html, $m)) {
    $sectionContent = $m[1];
    $sectionMatch = true;
} elseif (preg_match('/<h2>\s*API changes.*?<\/h2>(.*?)<h2/si', $html, $m)) {
    $sectionContent = $m[1];
    $sectionMatch = true;
}

if ($sectionMatch) {
    // Find <li> elements inside the section
    preg_match_all('/<li>(.*?)<\/li>/si', $sectionContent, $liMatches);

    $todos = [];
    foreach ($liMatches[1] as $li) {
        $text = strip_tags($li);
        $text = trim(preg_replace('/\s+/', ' ', $text));
        if ($text === '' || $text === '0') {
            continue;
        }

        $category = '[ ]';
        if (stripos($text, 'deprecated') !== false) {
            $category = '[ ] [DEPRECATED]';
        } elseif (stripos($text, 'removed') !== false) {
            $category = '[ ] [REMOVED]';
        } elseif (stripos($text, 'rename') !== false || stripos($text, 'moved') !== false) {
            $category = '[ ] [RENAME/MOVE]';
        }

        $todos[] = sprintf('- %s %s', $category, $text);
    }

    if ($todos === []) {
        echo sprintf("No API changes found in the 'API changes' section of %s%s", $htmlFile, PHP_EOL);
        exit(0);
    }

    $major = explode('.', $version)[0] ?? '';
    $outputFile = sprintf('docs/todos/ss-%s.md', $version);

    // Ensure output directory exists on fresh installs
    $outputDir = dirname($outputFile);
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0777, true);
    }

    $existingCompleted = [];
    if (file_exists($outputFile)) {
        $existingContent = file_get_contents($outputFile);
        // Match completed tasks: - [x] ...
        if ($existingContent && preg_match_all('/- \[x\] (?:\[.*?\] )?(.*)/i', $existingContent, $matches)) {
            foreach ($matches[1] as $completedTaskText) {
                $existingCompleted[] = trim($completedTaskText);
            }
        }
    }

    $finalTodos = [];
    foreach ($todos as $todoLine) {
        // Extract the text part of the new todo to compare with existing completed tasks
        // Format: - [ ] [CATEGORY] Task Text
        if (preg_match('/- \[ \] (?:\[.*?\] )?(.*)/i', $todoLine, $m)) {
            $taskText = trim($m[1]);
            if (in_array($taskText, $existingCompleted)) {
                $finalTodos[] = str_replace('- [ ]', '- [x]', $todoLine);
                continue;
            }
        }

        $finalTodos[] = $todoLine;
    }

    $content = "# Silverstripe {$version} Rector TODOs\n\n";
    $content .= "Original Changelog: [docs.silverstripe.org](https://docs.silverstripe.org/en/{$major}/changelogs/{$version}/#api-changes)\n\n";
    $content .= implode("\n", $finalTodos) . "\n";

    file_put_contents($outputFile, $content);
    echo sprintf('Updated TODO list: %s%s', $outputFile, PHP_EOL);
} else {
    echo sprintf("No 'API changes' section (h2 id=\"api-changes\") found in %s%s", $htmlFile, PHP_EOL);
}
