<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test json_decode directly
$raw = '"[\"MBBS\",\"MBBS\"]"';
echo "Raw string: $raw\n";
$decoded = json_decode($raw, true);
echo "Decoded: ";
var_dump($decoded);

// Test with actual DB value
$dbValue = DB::table('doctors')->first()->degrees;
echo "\nDB value: ";
var_dump($dbValue);
$decoded2 = json_decode($dbValue, true);
echo "Decoded from DB: ";
var_dump($decoded2);
