<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Applicant extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'marital_status',
        'postal_address',
        'country',
        'contact',
        'email_address',
        'residence',
        'next_of_kin',
        'next_of_kin_contact',
        'profession',
        'name_of_father',
        'profession_of_father',
        'name_of_mother',
        'profession_of_mother',
        'name_of_guardian',
        'profession_of_guardian',
        'is_parent_or_guardian_owning_house',
        'is_parent_or_guardian_renting_house',
        'is_parent_or_guardian_business_owner',
        'is_parent_or_guardian_car_owner',
        'name_of_travel_sponsor',
        'name_of_benefactor',
    ];


    public function churchInfo()
    {
        return $this->hasOne(ChurchInfo::class);
    }
    public function healthInfo()
    {
        return $this->hasOne(HealthInfo::class);
    }
    public function criminalInfo()
    {
        return $this->hasOne(CriminalInfo::class);
    }
    public function recommendationInfo()
    {
        return $this->hasOne(Recommendation::class);
    }
    public function socialInfo()
    {
        return $this->hasOne(SocialHistory::class);
    }
}