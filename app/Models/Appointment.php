<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'hospital_id',
        'type',
        'appointment_date',
        'time_slot',
        'status',
        'notes',
        'cancel_reason',
        'doctor_name',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
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

    public function vaccinationRecord()
    {
        return $this->hasOne(VaccinationRecord::class);
    }
}
