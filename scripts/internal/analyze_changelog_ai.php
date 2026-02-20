<?php
/**
 * AI-powered analyzer for Silverstripe changelog (HTML or Markdown).
 * Generates an optimized prompt for AI models to extract Rector-relevant changes.
 * 
 * Usage: php scripts/internal/analyze_changelog_ai.php <file>
 */

declare(strict_types=1);

if (!isset($argv[1])) {
    fwrite(STDERR, "Usage: php analyze_changelog_ai.php <file>\n");
    exit(1);
}

$inputFile = $argv[1];
if (!file_exists($inputFile)) {
    fwrite(STDERR, sprintf("File not found: %s%s", $inputFile, PHP_EOL));
    exit(1);
}

$version = basename($inputFile);
$version = str_replace(['ss-', '.html', '.md'], '', $version);
$isMarkdown = str_ends_with($inputFile, '.md');
$content = file_get_contents($inputFile) ?: '';

$relevantContent = '';

if ($isMarkdown) {
    // Markdown extraction logic
    $relevantContent = "## Version: {$version} (Markdown)\n\n";
    
    // Look for "API changes" and subsequent sub-sections
    if (preg_match('/## API changes(.*?)(?=\n## |$)/si', $content, $m)) {
        $relevantContent .= "### Section: API changes\n" . $m[1] . "\n\n";
    }
    
    // Also look for specific sections that might be top-level in MD
    $sectionsToParse = [
        'Many renamed classes',
        'Hooks renamed',
        'Deprecated API',
        'Deprecations',
        'Breaking changes',
    ];
    
    foreach ($sectionsToParse as $title) {
        // Don't duplicate if already captured in API changes
        if (preg_match('/## ' . preg_quote($title, '/') . '(.*?)(?=\n## |$)/si', $content, $m) && strpos($relevantContent, $title) === false) {
             $relevantContent .= sprintf('### Section: %s%s', $title, PHP_EOL) . $m[1] . "\n\n";
        }
    }
    
    // If still empty, take a large chunk
    if ($relevantContent === "## Version: {$version} (Markdown)\n\n") {
        $relevantContent .= $content;
    }
} else {
    // HTML extraction logic
    $html = $content;
    $relevantHtml = '';

    // Try to extract from "API changes" until the next major section or end
    if (preg_match('/<h2[^>]*id="api-changes"[^>]*>.*?(<\/h2>)(.*?)(?=<h2|$)/si', $html, $m)) {
        $relevantHtml = "## Section: API changes\n" . $m[2] . "\n\n";
    }

    $sectionsToParse = [
        'renamed-classes' => 'Many renamed classes',
        'hooks-renamed' => 'Hooks renamed',
        'deprecated-api' => 'Deprecated API',
        'api-deprecated' => 'Deprecated API',
        'deprecations' => 'Deprecations',
        'breaking-changes' => 'Breaking changes',
        'other-breaking-changes' => 'Other breaking changes',
    ];

    foreach ($sectionsToParse as $id => $title) {
        if (preg_match('/<h[23][^>]*>.*?' . preg_quote($title, '/') . '.*?(<\/h[23]>)(.*?)(?=<h[23]|$)/si', $html, $m) && strpos($relevantHtml, $title) === false) {
            $relevantHtml .= sprintf('## Section: %s%s', $title, PHP_EOL) . $m[2] . "\n\n";
        }
    }

    if ($relevantHtml === '') {
        foreach ($sectionsToParse as $id => $title) {
            if (preg_match('/<[^>]+id="' . $id . '"[^>]*>.*?(<\/h[23]>)(.*?)(?=<h[23]|$)/si', $html, $m) && strpos($relevantHtml, $title) === false) {
                $relevantHtml .= sprintf('## Section: %s%s', $title, PHP_EOL) . $m[2] . "\n\n";
            }
        }
    }

    if ($relevantHtml === '') {
        $relevantHtml = preg_match('/<h2.*?>(.*)/si', $html, $m) ? $m[1] : $html;
    }

    // Clean HTML
    $relevantHtml = strip_tags($relevantHtml, '<h1><h2><h3><h4><ul><li><ol><table><tr><td><th><a><code>');
    $relevantHtml = preg_replace('/\s+/', ' ', $relevantHtml);
    $relevantContent = $relevantHtml;
}

// 3. Prepare Prompt
$prompt = <<<PROMPT
You are an expert in Silverstripe CMS and Rector. Analyze the following content of a Silverstripe changelog for version {$version}.
Extract all changes that can potentially be automated with Rector:
- Class renames (Renames)
- Moved classes (Moves)
- Deprecated methods or classes (Deprecations)
- Changed method signatures
- Removed classes or methods

Format the result as a Markdown list with checkboxes, using exactly this format:
- [ ] [RENAME/MOVE] Old\\Namespace\\Class has been renamed to New\\Namespace\\Class
- [ ] [DEPRECATED] Method OldClass::method() is deprecated, use NewClass::method() instead
- [ ] [REMOVED] Class/Method ... has been removed.

IMPORTANT: Pay special attention to tables labeled "Many renamed classes".

Here is the content:
---
{$relevantContent}
---
PROMPT;

echo "--- PROMPT START ---\n";
echo $prompt;
echo "\n--- PROMPT END ---\n";

echo "\n\nNote: This script is a prototype for AI-assisted analysis.\n";
echo "Copy the prompt above into an AI (e.g. ChatGPT, Claude) to get the TODO list.\n";
