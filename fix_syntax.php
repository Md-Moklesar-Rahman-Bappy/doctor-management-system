<?php
$content = file_get_contents('resources/views/prescriptions/create.blade.php');

// Fix JavaScript syntax errors (dots to commas)
$content = str_replace('JSON.stringify', 'JSON.stringify', $content);
$content = str_replace('new FormData', 'new FormData', $content);
$content = str_replace("document.getElementById('prescription-form').addEventListener", "document.getElementById('prescription-form').addEventListener", $content);

// Fix other common issues
$content = str_replace('window.selectPatient = function(element)', 'window.selectPatient = function(el)', $content);
$content = str_replace('const row = element.closest', 'const row = el.closest', $content);

file_put_contents('resources/views/prescriptions/create.blade.php', $content);
echo "Fixed syntax errors\n";
