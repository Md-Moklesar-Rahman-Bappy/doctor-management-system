<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'doctor_id', 'patient_id', 'problem', 'tests', 'medicines'];

    protected $casts = [
        'problem' => 'json',
        'tests' => 'json',
        'medicines' => 'json',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function labTestReports()
    {
        return $this->hasManyThrough(LabTestReport::class, Patient::class);
    }
}
