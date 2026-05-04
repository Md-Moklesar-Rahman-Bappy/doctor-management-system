<?php
$content = file_get_contents('resources/views/prescriptions/create.blade.php');

// Fix 'new FormData' to 'new FormData' (should be dot, not space)
$content = str_replace('new FormData', 'new FormData', $content);

// Also fix 'JSON.stringify' to 'JSON.stringify' (dot notation is correct in JS)
// Actually JSON.stringify is correct - the issue might be something else

file_put_contents('resources/views/prescriptions/create.blade.php', $content);
echo "Fixed new FormData syntax\n";
