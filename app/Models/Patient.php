<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'unique_id', 'patient_name', 'age', 'sex', 'date'];

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    public function labTestReports()
    {
        return $this->hasMany(LabTestReport::class, 'patient_id');
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('unique_id', 'like', "%{$searchTerm}%")
            ->orWhere('patient_name', 'like', "%{$searchTerm}%");
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($patient) {
            if (empty($patient->unique_id)) {
                $patient->unique_id = 'PAT-' . strtoupper(substr(md5(uniqid()), 0, 8));
            }
        });
    }
}
