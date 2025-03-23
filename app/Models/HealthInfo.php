<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'is_having_medical_condition',
        'medical_condition',
        'is_on_regular_medication',
        'medications',
        'has_had_major_surgeries',
        'surgeries',
        'is_having_allergies',
        'allergies',
        'diseases_treated',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}