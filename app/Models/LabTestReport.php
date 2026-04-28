<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTestReport extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'test_name', 'report_text', 'report_image'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('test_name', 'like', "%{$searchTerm}%")
            ->orWhereHas('patient', function ($q) use ($searchTerm) {
                $q->where('unique_id', 'like', "%{$searchTerm}%");
            });
    }
}
