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

// Extract multiple potential sections: "API changes", "Many renamed classes", etc.
$sectionsToParse = [
    'api-changes' => 'API changes',
    'renamed-classes' => 'Many renamed classes',
];

$sectionContent = '';
$sectionMatch = false;

foreach ($sectionsToParse as $id => $title) {
    if (preg_match('/<h[23] id="' . $id . '">.*?(<\/h[23]>)(.*?)(?:<h[23]|$)/si', $html, $m)) {
        $sectionContent .= $m[2];
        $sectionMatch = true;
    } elseif (preg_match('/<h[23]>.*?' . $title . '.*?(<\/h[23]>)(.*?)(?:<h[23]|$)/si', $html, $m)) {
        $sectionContent .= $m[2];
        $sectionMatch = true;
    }
}

if ($sectionMatch) {
    // Find <li> elements inside the section
    preg_match_all('/<li>(.*?)<\/li>/si', $sectionContent, $liMatches);

    // Also look for tables, which are common in "renamed-classes"
    preg_match_all('/<tr>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<\/tr>/si', $sectionContent, $tableMatches);

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

    foreach ($tableMatches[1] as $i => $oldClass) {
        $newClass = strip_tags($tableMatches[2][$i]);
        $oldClass = strip_tags($oldClass);

        $text = sprintf('%s has been renamed to %s', trim($oldClass), trim($newClass));
        $todos[] = sprintf('- [ ] [RENAME/MOVE] %s', $text);
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
    $seenTasks = [];
    foreach ($todos as $todoLine) {
        // Extract the text part of the new todo to compare with existing completed tasks
        // Format: - [ ] [CATEGORY] Task Text
        if (preg_match('/- \[ \] (?:\[.*?\] )?(.*)/i', $todoLine, $m)) {
            $taskText = trim($m[1]);
            if (isset($seenTasks[$taskText])) {
                continue;
            }

            $seenTasks[$taskText] = true;

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
