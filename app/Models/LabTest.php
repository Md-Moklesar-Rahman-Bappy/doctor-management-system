<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    use HasFactory;

    protected $table = 'lab_tests';

    protected $fillable = [
        'department',
        'sample_type',
        'panel',
        'test',
        'code',
        'unit',
        'result_type',
        'normal_range'
    ];

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('test', 'like', "%{$searchTerm}%")
            ->orWhere('code', 'like', "%{$searchTerm}%")
            ->orWhere('department', 'like', "%{$searchTerm}%");
    }

    public static function getPreAddedTests()
    {
        return [
            ['department' => 'Blood Test', 'sample_type' => 'Blood', 'panel' => 'Basic', 'test' => 'Complete Blood Count', 'code' => 'CBC-001', 'unit' => 'cells/mcL', 'result_type' => 'numeric', 'normal_range' => '4500-11000'],
            ['department' => 'Blood Test', 'sample_type' => 'Blood', 'panel' => 'Basic', 'test' => 'Blood Sugar', 'code' => 'BS-002', 'unit' => 'mg/dL', 'result_type' => 'numeric', 'normal_range' => '70-100'],
            ['department' => 'Imaging', 'sample_type' => 'X-Ray', 'panel' => 'Imaging', 'test' => 'X-Ray Chest', 'code' => 'XRAY-003', 'unit' => '', 'result_type' => 'text', 'normal_range' => 'Normal'],
            ['department' => 'Cardiology', 'sample_type' => 'ECG', 'panel' => 'Cardiac', 'test' => 'ECG', 'code' => 'ECG-004', 'unit' => '', 'result_type' => 'text', 'normal_range' => 'Normal'],
            ['department' => 'Urine Test', 'sample_type' => 'Urine', 'panel' => 'Basic', 'test' => 'Urinalysis', 'code' => 'UA-005', 'unit' => '', 'result_type' => 'text', 'normal_range' => 'Normal'],
            ['department' => 'Blood Test', 'sample_type' => 'Blood', 'panel' => 'Metabolic', 'test' => 'Complete Metabolic Panel', 'code' => 'CMP-006', 'unit' => 'mg/dL', 'result_type' => 'numeric', 'normal_range' => 'Varies'],
            ['department' => 'Blood Test', 'sample_type' => 'Blood', 'panel' => 'Lipid', 'test' => 'Lipid Profile', 'code' => 'LP-007', 'unit' => 'mg/dL', 'result_type' => 'numeric', 'normal_range' => '<200'],
            ['department' => 'Blood Test', 'sample_type' => 'Blood', 'panel' => 'Thyroid', 'test' => 'Thyroid Function Test', 'code' => 'TFT-008', 'unit' => 'mIU/L', 'result_type' => 'numeric', 'normal_range' => '0.4-4.0'],
        ];
    }
}
