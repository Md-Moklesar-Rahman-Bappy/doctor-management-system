<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;

    protected $fillable = ['problem_name'];

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('problem_name', 'like', "%{$searchTerm}%");
    }
}
