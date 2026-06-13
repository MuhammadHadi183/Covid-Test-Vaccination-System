<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'vaccine_id',
        'quantity',
        'expiry_date',
    ];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
        ];
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }
}
