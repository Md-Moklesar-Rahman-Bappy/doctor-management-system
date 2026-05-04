<?php
$content = file_get_contents('resources/views/prescriptions/create.blade.php');

// Fix dots vs commas in JavaScript
// In JavaScript, object properties use commas, not dots
// But method calls use dots - so JSON.stringify is CORRECT (dot)
// The issue is property separators should be commas

// Let me check for the actual issue - maybe it's the blade template outputting wrong
// Let me search for problematic patterns

$lines = explode("\n", $content);
$fixed = 0;

foreach ($lines as $i => $line) {
    // Check for lines with multiple property assignments using dots instead of commas
    // Example: property: value.property: value (wrong)
    // Should be: property: value, property: value (correct)
    
    if (strpos($line, '.classList') !== false || strpos($line, '.classList') !== false) {
        // These are correct - they're method calls
        continue;
    }
}

// The real issue might be in the blade template itself
// Let me check if the file has proper PHP/Blade syntax
echo "Checking blade syntax...\n";

// Check for unclosed @push/@endpush
$pushCount = substr_count($content, "@push(");
$endPushCount = substr_count($content, "@endpush");

echo "push count: $pushCount, endpush count: $endPushCount\n";

if ($pushCount != $endPushCount) {
    echo "ERROR: Mismatched @push/@endpush tags!\n";
}

// Check for unclosed <script> tags
$scriptOpen = substr_count($content, "<script>");
$scriptClose = substr_count($content, "</script>");

echo "script open: $scriptOpen, script close: $scriptClose\n";

if ($scriptOpen != $scriptClose) {
    echo "ERROR: Mismatched script tags!\n";
}

echo "Done checking\n";
