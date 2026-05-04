<?php
$content = file_get_contents('resources/views/prescriptions/create.blade.php');

// Check for JSON.stringify (should be comma, not dot)
$pos = strpos($content, 'JSON.stringify');
if ($pos !== false) {
    $char = substr($content, $pos + 4, 1);
    echo "Found 'JSON.stringify' at $pos\n";
    echo "Character after 'JSON': ASCII=" . ord($char) . " char='$char'\n";
    
    // In JavaScript, JSON.stringify is correct (dot notation)
    // The issue is the blade template is outputting it wrong
    // Let me check if it's actually JSON.stringify (correct) or JSON.stringify (wrong)
}

// Check for the actual issue - maybe it's JSON.stringify in the blade output
// Let me search for the pattern more carefully
$lines = explode("\n", $content);
foreach ($lines as $i => $line) {
    if (strpos($line, 'JSON.stringify') !== false) {
        echo "Line " . ($i+1) . ": " . trim($line) . "\n";
    }
    if (strpos($line, 'new FormData') !== false) {
        echo "Line " . ($i+1) . ": " . trim($line) . "\n";
    }
}

echo "\nDone\n";
