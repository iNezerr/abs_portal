<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recommendation extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;


    protected $fillable = [
        'applicant_id',
        'recommended_by',
        'recommendation_by_other',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
