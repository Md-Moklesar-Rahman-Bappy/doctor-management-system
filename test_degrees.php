<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$p = \App\Models\Prescription::with('doctor')->first();
echo "Type of degrees: " . gettype($p->doctor->degrees) . "\n";
echo "Value: ";
var_dump($p->doctor->degrees);
