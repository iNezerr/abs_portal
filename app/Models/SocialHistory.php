<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'use_narcotics_currently',
        'current_narcotics_history',
        'use_narcotics_in_past',
        'past_narcotics_history',
        'have_been_arrested_before',
        'arrest_history',
        'have_been_prosecuted_before',
        'prosecution_history',
        'have_been_jailed_before',
        'jail_history',
        'is_taking_alcohol',
        'alcohol_history',
        'use_alcohol_in_past',
        'past_alcohol_history',
        'have_been_involved_in_robbery',
        'past_robbery_history',
        'have_been_a_rebel',
        'past_rebelious_history',
        'have_been_in_prostitution',
        'past_prostitution_history',
        'vices',
        'is_virgin',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
