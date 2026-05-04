<?php
$content = file_get_contents('resources/views/prescriptions/create.blade.php');

// Check for the problematic string
$pos = strpos($content, 'JSON.stringify');
if ($pos !== false) {
    echo "Found 'JSON.stringify' at position: $pos\n";
    $char = substr($content, $pos + 4, 1);
    echo "Character after 'JSON': ASCII=" . ord($char) . " char='$char'\n";
    
    // Check if it's a dot (46) or comma (44)
    if (ord($char) == 46) {
        echo "ERROR: Found dot (.) instead of comma (,)\n";
    } elseif (ord($char) == 44) {
        echo "OK: Found comma (,)\n";
    }
}

// Check for 'new FormData'
$pos2 = strpos($content, 'new FormData');
if ($pos2 !== false) {
    $char2 = substr($content, $pos2 + 3, 1);
    echo "Character after 'new': ASCII=" . ord($char2) . "\n";
    if (ord($char2) == 32) {
        echo "OK: Found space after 'new'\n";
    }
}

echo "\nDone checking\n";
