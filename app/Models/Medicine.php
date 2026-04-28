<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_name',
        'generic_name',
        'dosage_type',
        'strength',
        'company_name',
        'package_mark'
    ];

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('brand_name', 'like', "%{$searchTerm}%")
                    ->orWhere('company_name', 'like', "%{$searchTerm}%");
    }
}
