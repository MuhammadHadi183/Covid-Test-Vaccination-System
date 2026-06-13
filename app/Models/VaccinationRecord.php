<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'hospital_id',
        'appointment_id',
        'vaccine_id',
        'dose_number',
        'status',
        'vaccinated_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'vaccinated_at' => 'datetime',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }
}
