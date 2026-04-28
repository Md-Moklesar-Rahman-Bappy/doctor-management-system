<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

for($i=1; $i<=15; $i++){
    App\Models\LabTest::create([
        'department'=>'Biochemistry',
        'sample_type'=>'Blood',
        'panel'=>'LFT',
        'test'=>'Test '.$i,
        'short_code'=>'T'.$i,
        'unit'=>'U/L',
        'result_type'=>'Numeric',
        'normal_range_lower'=>10,
        'normal_range_upper'=>50
    ]);
}
echo "Created 15 tests";