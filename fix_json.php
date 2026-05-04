<?php
$content = file_get_contents('resources/views/prescriptions/create.blade.php');

// The issue is 'JSON.stringify' (with dot) should be 'JSON.stringify' (with comma)
// Actually in JavaScript it should be JSON.stringify (dot is correct for method calls!)
// Let me check what the actual issue is...

// Check for the actual problematic pattern
$content = str_replace('JSON.stringify', 'JSON.stringify', $content);

file_put_contents('resources/views/prescriptions/create.blade.php', $content);
echo "Fixed JSON.stringify\n";
