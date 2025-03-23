<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChurchInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'is_born_again',
        'is_called',
        'explain_calling',
        'church',
        'role_in_church',
        'duration_of_service',
        'history_before_born_again',
        'history_of_present_church',
        'history_of_roles_in_church',
        'reason_for_coming_to_bible_school',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}