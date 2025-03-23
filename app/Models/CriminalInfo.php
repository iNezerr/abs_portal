<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriminalInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'is_having_criminal_record',
        'criminal_records',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}