<?php namespace App\Exports; 

use App\Models\Patient; 
use App\Models\PatientRequest; 
use App\Models\User; 
use App\Models\CovidTest; 
use App\Models\VaccinationRecord; 
use App\Models\Vaccine; 
use App\Models\Hospital; 
use App\Models\Appointment; 
use App\Models\VaccineStock; 
use Illuminate\Contracts\View\View; 
use Maatwebsite\Excel\Concerns\FromView; 
use Maatwebsite\Excel\Concerns\ShouldAutoSize; 

class MedTrackExport implements FromView, ShouldAutoSize { 
    public function view(): View{ 
        $Appointments = Appointment::all(); 
        $CovidTests = CovidTest::all(); 
        $Vaccines = Vaccine::all(); 
        $Hospitals = Hospital::all(); 
        $Patients = Patient::all(); 
        $PatientRequests = PatientRequest::all(); 
        $Users = User::all(); 
        $VaccinationRecords = VaccinationRecord::all(); 
        $VaccineStocks = VaccineStock::all(); 

        return view('Exports.MedTrackData', [ 
            'Appointments' => $Appointments,
            'CovidTests' => $CovidTests,
            'Vaccines' => $Vaccines,
            'Hospitals' => $Hospitals,
            'Patients' => $Patients,
            'PatientRequests' => $PatientRequests,
            'Users' => $Users,
            'VaccinationRecords' => $VaccinationRecords,
            'VaccineStocks' => $VaccineStocks
        ]); 
    } 
}
