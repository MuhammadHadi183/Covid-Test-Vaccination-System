<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hospital_name',
        'registration_no',
        'address',
        'city',
        'phone',
        'description',
        'status',
        'logo',
        'email',
        'website',
        'established_year',
        'operating_hours',
        'total_rooms',
        'total_beds',
        'icu_beds',
        'emergency_available',
        'ambulance_available',
        'doctors_list',
        'special_doctors',
        'specialties',
        'facilities',
        'rating',
        'total_reviews',
        'reviews',
        'profile_completed',
        'medicines',
    ];

    protected $casts = [
        'doctors_list' => 'array',
        'special_doctors' => 'array',
        'specialties' => 'array',
        'facilities' => 'array',
        'reviews' => 'array',
        'medicines' => 'array',
        'emergency_available' => 'boolean',
        'ambulance_available' => 'boolean',
        'profile_completed' => 'boolean',
        'rating' => 'decimal:1',
    ];

    public function scopePublicProfile($Query)
    {
        return $Query->where('status', 'approved')->where('profile_completed', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vaccineStocks()
    {
        return $this->hasMany(VaccineStock::class);
    }

    public function covidTests()
    {
        return $this->hasMany(CovidTest::class);
    }

    public function vaccinationRecords()
    {
        return $this->hasMany(VaccinationRecord::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function patientRequests()
    {
        return $this->hasMany(PatientRequest::class);
    }

    public function vaccines()
    {
        return $this->hasMany(Vaccine::class);
    }
}
