<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\CovidTest;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\PatientRequest;
use App\Models\VaccinationRecord;
use App\Models\VaccineStock;
use App\Models\Vaccine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class HospitalController extends Controller
{
    private function getHospital(): Hospital
    {
        $User     = auth()->user();
        $Hospital = $User->hospital;
        return $Hospital;
    }

    public function dashboard()
    {
        $Hospital = $this->getHospital();

        $TotalPatients = PatientRequest::where('hospital_id', $Hospital->id)
            ->where('status', 'approved')
            ->distinct('patient_id')
            ->count('patient_id');

        $PendingRequests = PatientRequest::where('hospital_id', $Hospital->id)
            ->where('status', 'pending')
            ->count();

        $TodayTests = CovidTest::where('hospital_id', $Hospital->id)
            ->whereDate('created_at', today())
            ->count();

        $TotalVaccinations = VaccinationRecord::where('hospital_id', $Hospital->id)
            ->where('status', 'completed')
            ->count();

        $TodayAppointments = Appointment::with('patient.user')
            ->where('hospital_id', $Hospital->id)
            ->whereDate('appointment_date', today())
            ->orderBy('time_slot')
            ->get();

        $RecentRequests = PatientRequest::with('patient.user')
            ->where('hospital_id', $Hospital->id)
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $Stocks = VaccineStock::with('vaccine')
            ->where('hospital_id', $Hospital->id)
            ->get();

        return view('hospital.dashboard', compact(
            'Hospital',
            'TotalPatients',
            'PendingRequests',
            'TodayTests',
            'TotalVaccinations',
            'TodayAppointments',
            'RecentRequests',
            'Stocks'
        ));
    }

    public function patients()
    {
        $Hospital = $this->getHospital();

        $Patients = PatientRequest::with('patient.user')
            ->where('hospital_id', $Hospital->id)
            ->where('status', 'approved')
            ->latest()
            ->paginate(15);

        return view('hospital.patients', compact('Patients'));
    }


    public function requests()
    {
        $Hospital = $this->getHospital();

        $Requests = PatientRequest::with('patient.user')
            ->where('hospital_id', $Hospital->id)
            ->latest()
            ->paginate(15);

        return view('hospital.requests', compact('Requests'));
    }

    public function appointments(Request $Request)
    {
        $Hospital = $this->getHospital();

        $Status = $Request->query('status', 'all');

        $Query = Appointment::with(['patient.user', 'vaccinationRecord.vaccine'])
            ->where('hospital_id', $Hospital->id)
            ->orderByDesc('appointment_date');

        if ($Status && $Status !== 'all') {
            $Query->where('status', $Status);
        }

        $Appointments = $Query->paginate(15)->withQueryString();

        $VaccineStocksForAppt = VaccineStock::with('vaccine')
            ->where('hospital_id', $Hospital->id)
            ->where('quantity', '>', 0)
            ->orderBy('vaccine_id')
            ->get();

        return view('hospital.appointments', compact('Appointments', 'Status', 'VaccineStocksForAppt', 'Hospital'));
    }


    public function updateAppointmentStatus(Request $Request, $Id)
    {
        $Hospital    = $this->getHospital();
        $Appointment = Appointment::where('hospital_id', $Hospital->id)->findOrFail($Id);

        $Request->validate([
            'status'        => ['required', Rule::in(['pending', 'confirmed', 'completed', 'cancelled'])],
            'cancel_reason' => ['required_if:status,cancelled', 'nullable', 'string', 'max:2000'],
        ]);

        if (in_array($Request->status, ['confirmed', 'completed'])) {
            $Request->validate([
                'doctor_name' => ['required', 'string'],
            ]);
        }

        if ($Request->status === 'completed' && $Appointment->type === 'vaccination') {
            $Request->validate([
                'vaccine_id'  => ['required', $this->vaccineIdExistsInCatalogForHospital($Hospital)],
                'dose_number' => ['required', 'integer', 'min:1', 'max:10'],
            ]);
        }

        $OldStatus = $Appointment->status;

        $Data                  = ['status' => $Request->status];
        $Data['cancel_reason'] = $Request->status === 'cancelled' ? $Request->input('cancel_reason') : null;
        
        if (in_array($Request->status, ['confirmed', 'completed'])) {
            $Data['doctor_name'] = $Request->doctor_name;
        }

        if ($Appointment->type === 'vaccination' && $OldStatus === 'completed' && $Request->status !== 'completed') {
            $this->removeAppointmentVaccinationRecord($Appointment, $Hospital);
        }
        
        $Appointment->update($Data);

        if ($Appointment->type === 'vaccination' && $Request->status === 'completed' && $OldStatus !== 'completed') {
            $Result = $this->createAppointmentVaccinationRecordFromRequest($Appointment, $Hospital, $Request);

            if ($Result === 'no_stock') {
                return back()->withErrors([
                    'vaccine_id' => 'No stock left for this vaccine. Add stock under Vaccine stock, or pick another vaccine.',
                ])->withInput();
            }
        }

        if ($OldStatus !== 'confirmed' && $Request->status === 'confirmed') {
            if ($Appointment->patient && $Appointment->patient->user) {
                \Illuminate\Support\Facades\Mail::to($Appointment->patient->user->email)
                    ->send(new \App\Mail\AppointmentConfirmedMail($Appointment));
            }
        }

        return back()->with('success', 'Appointment status updated.');
    }


    public function approveRequest($Id)
    {
        $PatientRequest = PatientRequest::where('hospital_id', $this->getHospital()->id)->findOrFail($Id);

        abort_unless($PatientRequest->status === 'pending', 403, 'This request is no longer pending.');

        $PatientRequest->update(['status' => 'approved']);

        return back()->with('success', 'Request approved successfully.');
    }

    public function rejectRequest($Id)
    {
        $PatientRequest = PatientRequest::where('hospital_id', $this->getHospital()->id)->findOrFail($Id);

        abort_unless($PatientRequest->status === 'pending', 403, 'This request is no longer pending.');

        $PatientRequest->update(['status' => 'rejected']);

        return back()->with('success', 'Request rejected.');
    }

    
    public function covidResults()
    {
        $Hospital = $this->getHospital();

        $PatientIds = PatientRequest::where('hospital_id', $Hospital->id)
            ->where('status', 'approved')
            ->pluck('patient_id')
            ->unique()
            ->filter();

        $Patients = Patient::with('user')
            ->whereIn('id', $PatientIds)
            ->orderBy('id')
            ->get();

        $Tests = CovidTest::with('patient.user')
            ->where('hospital_id', $Hospital->id)
            ->latest()
            ->paginate(15);

        return view('hospital.covid-results', compact('Tests', 'Patients'));
    }

    public function storeCovidResult(Request $Request)
    {
        $Hospital = $this->getHospital();

        $Request->validate([
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'test_type'  => ['required', Rule::in(['PCR', 'Antigen RAT'])],
            'result'     => ['nullable', Rule::in(['pending', 'positive', 'negative'])],
            'ct_value'   => 'nullable|numeric',
            'notes'      => 'nullable|string|max:500',
        ]);

        $IsLinked = PatientRequest::where('hospital_id', $Hospital->id)
            ->where('status', 'approved')
            ->where('patient_id', $Request->patient_id)
            ->exists();

        if (!$IsLinked) {
            return back()->withErrors([
                'patient_id' => 'Choose a patient with an approved request at your hospital.',
            ])->withInput();
        }

        $Result = $Request->input('result', 'pending');

        CovidTest::create([
            'patient_id'  => $Request->patient_id,
            'hospital_id' => $Hospital->id,
            'test_type'   => $Request->test_type,
            'result'      => $Result,
            'ct_value'    => $Request->ct_value,
            'notes'       => $Request->notes,
            'tested_at'   => $Result !== 'pending' ? now() : null,
        ]);

        return back()->with('success', 'COVID test record added.');
    }
    public function updateResult(Request $Request, $Id)
    {
        $Request->validate([
            'result'   => 'required|in:pending,positive,negative',
            'ct_value' => 'nullable|numeric',
        ]);

        $Hospital = $this->getHospital();
        $Test     = CovidTest::where('hospital_id', $Hospital->id)->findOrFail($Id);

        $Test->update([
            'result'    => $Request->result,
            'ct_value'  => $Request->ct_value,
            'tested_at' => $Request->result === 'pending' ? null : now(),
        ]);

        return back()->with('success', 'Test result updated.');
    }

    public function vaccineStocks()
    {
        $Hospital = $this->getHospital();

        $Stocks = VaccineStock::with('vaccine')
            ->where('hospital_id', $Hospital->id)
            ->orderBy('id')
            ->get();

        $Vaccines = Vaccine::query()
            ->where(function ($q) use ($Hospital) {
                $q->whereNull('hospital_id')->orWhere('hospital_id', $Hospital->id);
            })
            ->orderBy('name')
            ->get();

        return view('hospital.vaccine-stocks', compact('Hospital', 'Stocks', 'Vaccines'));
    }

   
    public function storeVaccineStock(Request $Request)
    {
        $Hospital = $this->getHospital();

        $Request->validate([
            'vaccine_id'  => ['required', $this->vaccineIdExistsInCatalogForHospital($Hospital)],
            'quantity'    => ['required', 'integer', 'min:1'],
            'expiry_date' => 'nullable|date',
        ]);

        $Stock = VaccineStock::firstOrNew(
            ['hospital_id' => $Hospital->id, 'vaccine_id' => $Request->vaccine_id],
            ['quantity' => 0]
        );

        $Stock->quantity = (int) $Stock->quantity + (int) $Request->quantity;

        if ($Request->filled('expiry_date')) {
            $Stock->expiry_date = $Request->expiry_date;
        }

        $Stock->save();

        $this->syncVaccineCatalogStatus((int) $Request->vaccine_id);

        return back()->with('success', 'Vaccine stock added. If this vaccine already had a row here, quantity was increased.');
    }

    
    public function storeHospitalVaccine(Request $Request)
    {
        $Hospital = $this->getHospital();

        $Request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'manufacturer'   => ['required', 'string', 'max:255'],
            'doses_required' => ['required', 'integer', 'min:1', 'max:10'],
            'description'    => ['nullable', 'string', 'max:2000'],
        ]);

        Vaccine::create([
            'hospital_id'    => $Hospital->id,
            'name'           => $Request->name,
            'manufacturer'   => $Request->manufacturer,
            'doses_required' => $Request->doses_required,
            'description'    => $Request->description,
            'status'         => 'unavailable', 
        ]);

        return back()->with('success', 'Vaccine added to your catalog. Add stock below so you can use it in appointments and records.');
    }

    public function updateVaccineStock(Request $Request, $Id)
    {
        $Hospital = $this->getHospital();
        $Stock    = VaccineStock::where('hospital_id', $Hospital->id)->findOrFail($Id);

        $Request->validate([
            'quantity'    => ['required', 'integer', 'min:0'],
            'expiry_date' => 'nullable|date',
        ]);

        $VaccineId = (int) $Stock->vaccine_id;

        if ((int) $Request->quantity === 0) {
            $Stock->delete();
            $this->syncVaccineCatalogStatus($VaccineId);
            return back()->with('success', 'Stock line removed.');
        }

        $Stock->update([
            'quantity'    => (int) $Request->quantity,
            'expiry_date' => $Request->filled('expiry_date') ? $Request->expiry_date : null,
        ]);

        $this->syncVaccineCatalogStatus($VaccineId);

        return back()->with('success', 'Stock updated.');
    }

       public function deleteVaccineStock($Id)
    {
        $Hospital  = $this->getHospital();
        $Stock     = VaccineStock::where('hospital_id', $Hospital->id)->findOrFail($Id);
        $VaccineId = (int) $Stock->vaccine_id;

        $Stock->delete();

        $this->syncVaccineCatalogStatus($VaccineId);

        return back()->with('success', 'Stock deleted.');
    }

    
    private function syncVaccineCatalogStatus(int $vaccineId): void
    {
        $Vaccine = Vaccine::find($vaccineId);

      
        if (!$Vaccine) {
            return;
        }

        $TotalStock = $Vaccine->stocks()->sum('quantity');

        $Vaccine->update(['status' => $TotalStock > 0 ? 'available' : 'unavailable']);
    }

    public function vaccinations()
    {
        $Hospital = $this->getHospital();

        $Vaccinations = VaccinationRecord::with(['patient.user', 'vaccine'])
            ->where('hospital_id', $Hospital->id)
            ->latest()
            ->paginate(15);

        $PatientIdsFromRequests = PatientRequest::where('hospital_id', $Hospital->id)
            ->where('status', 'approved')
            ->pluck('patient_id');

        $PatientIdsFromAppointments = Appointment::where('hospital_id', $Hospital->id)
            ->where('type', 'vaccination')
            ->pluck('patient_id');

        $PatientIds = $PatientIdsFromRequests->merge($PatientIdsFromAppointments)->unique()->filter();

        $PatientsForVax = Patient::with('user')
            ->whereIn('id', $PatientIds)
            ->orderBy('id')
            ->get();

        $VaccineStocks = VaccineStock::with('vaccine')
            ->where('hospital_id', $Hospital->id)
            ->where('quantity', '>', 0)
            ->orderBy('vaccine_id')
            ->get();

        return view('hospital.vaccinations', compact('Vaccinations', 'PatientsForVax', 'VaccineStocks'));
    }


    public function storeVaccination(Request $Request)
    {
        $Hospital = $this->getHospital();

        $Request->validate([
            'patient_id'  => ['required', 'integer', 'exists:patients,id'],
            'vaccine_id'  => ['required', 'integer', $this->vaccineIdExistsInCatalogForHospital($Hospital)],
            'dose_number' => ['required', 'integer', 'min:1', 'max:10'],
            'status'      => ['required', Rule::in(['scheduled', 'completed', 'cancelled'])],
            'notes'       => ['nullable', 'string', 'max:500'],
        ]);

        $HasApprovedRequest = PatientRequest::where('hospital_id', $Hospital->id)
            ->where('status', 'approved')
            ->where('patient_id', $Request->patient_id)
            ->exists();

        $HasVaccinationAppointment = Appointment::where('hospital_id', $Hospital->id)
            ->where('patient_id', $Request->patient_id)
            ->where('type', 'vaccination')
            ->exists();

        if (!$HasApprovedRequest && !$HasVaccinationAppointment) {
            return back()->withErrors([
                'patient_id' => 'Choose a patient who has an approved request at your hospital or a vaccination appointment booked here.',
            ])->withInput();
        }

        $Status = $Request->status;

        if ($Status === 'cancelled') {
            VaccinationRecord::create([
                'patient_id'    => $Request->patient_id,
                'hospital_id'   => $Hospital->id,
                'vaccine_id'    => $Request->vaccine_id,
                'dose_number'   => $Request->dose_number,
                'status'        => 'cancelled',
                'vaccinated_at' => null,
                'notes'         => $Request->notes,
            ]);

            return back()->with('success', 'Vaccination record added.');
        }

        $Stock = VaccineStock::where('hospital_id', $Hospital->id)
            ->where('vaccine_id', $Request->vaccine_id)
            ->first();

        if (!$Stock || (int) $Stock->quantity < 1) {
            return back()->withErrors([
                'vaccine_id' => 'No stock left for this vaccine at your hospital. Add stock under Vaccine stock.',
            ])->withInput();
        }

        if ($Status === 'completed') {
            $Stock->decrement('quantity');
            $this->syncVaccineCatalogStatus((int) $Request->vaccine_id);
        }

        VaccinationRecord::create([
            'patient_id'    => $Request->patient_id,
            'hospital_id'   => $Hospital->id,
            'vaccine_id'    => $Request->vaccine_id,
            'dose_number'   => $Request->dose_number,
            'status'        => $Status,
            'vaccinated_at' => $Status === 'completed' ? now() : null,
            'notes'         => $Request->notes,
        ]);

        return back()->with('success', 'Vaccination record added.');
    }


    public function updateVaccination(Request $Request, $Id)
    {
        $Request->validate([
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        $Hospital  = $this->getHospital();
        $Record    = VaccinationRecord::where('hospital_id', $Hospital->id)->findOrFail($Id);
        $OldStatus = $Record->status;
        $NewStatus = $Request->status;
        $VaccineId = (int) $Record->vaccine_id;

        if ($OldStatus !== 'completed' && $NewStatus === 'completed') {
            $Stock = VaccineStock::where('hospital_id', $Hospital->id)
                ->where('vaccine_id', $VaccineId)
                ->first();

            if (!$Stock || (int) $Stock->quantity < 1) {
                return back()->withErrors([
                    'status' => 'Cannot mark completed: no stock left for this vaccine. Add stock or choose another status.',
                ]);
            }

            $Stock->decrement('quantity');
            $this->syncVaccineCatalogStatus($VaccineId);
        }

        if ($OldStatus === 'completed' && $NewStatus !== 'completed') {
            $Stock = VaccineStock::firstOrNew(
                ['hospital_id' => $Hospital->id, 'vaccine_id' => $VaccineId],
                ['quantity' => 0]
            );
            $Stock->quantity = (int) $Stock->quantity + 1;
            $Stock->save();
            $this->syncVaccineCatalogStatus($VaccineId);
        }

        $Data = ['status' => $NewStatus];

        if ($NewStatus === 'completed') {
            $Data['vaccinated_at'] = $Record->vaccinated_at ?? now();
        } else {
            $Data['vaccinated_at'] = null;
        }

        $Record->update($Data);

        return back()->with('success', 'Vaccination status updated.');
    }

    private function vaccineIdExistsInCatalogForHospital(Hospital $Hospital): \Illuminate\Validation\Rules\Exists
    {
        return Rule::exists('vaccines', 'id')->where(function ($query) use ($Hospital) {
            $query->whereNull('hospital_id')->orWhere('hospital_id', $Hospital->id);
        });
    }

    private function removeAppointmentVaccinationRecord(Appointment $Appointment, Hospital $Hospital): void
    {
        $Record = VaccinationRecord::where('appointment_id', $Appointment->id)->first();

        if (!$Record) {
            return;
        }

        if ($Record->status === 'completed') {
            $VaccineId = (int) $Record->vaccine_id;

            $Stock = VaccineStock::firstOrNew(
                ['hospital_id' => $Hospital->id, 'vaccine_id' => $VaccineId],
                ['quantity' => 0]
            );
            $Stock->quantity = (int) $Stock->quantity + 1;
            $Stock->save();

            $this->syncVaccineCatalogStatus($VaccineId);
        }

        $Record->delete();
    }

   
    private function createAppointmentVaccinationRecordFromRequest(Appointment $Appointment, Hospital $Hospital, Request $Request): ?string
    {
        if (VaccinationRecord::where('appointment_id', $Appointment->id)->exists()) {
            return null;
        }

        $Stock = VaccineStock::where('hospital_id', $Hospital->id)
            ->where('vaccine_id', $Request->vaccine_id)
            ->first();

        if (!$Stock || (int) $Stock->quantity < 1) {
            return 'no_stock';
        }

        
        $Stock->decrement('quantity');
        $this->syncVaccineCatalogStatus((int) $Request->vaccine_id);

        VaccinationRecord::create([
            'patient_id'     => $Appointment->patient_id,
            'hospital_id'    => $Hospital->id,
            'appointment_id' => $Appointment->id,
            'vaccine_id'     => $Request->vaccine_id,
            'dose_number'    => $Request->dose_number,
            'status'         => 'completed',
            'vaccinated_at'  => now(),
            'notes'          => $Appointment->notes,
        ]);

        return null; 
    }



    public function profile()
    {
        $Hospital = $this->getHospital();
        return view('hospital.profile', compact('Hospital'));
    }

    public function updateProfile(Request $Request)
    {
        $Hospital = $this->getHospital();

        $Request->validate([
            'hospital_name'    => 'required|string|max:255',
            'email'            => 'nullable|email|max:255',
            'phone'            => 'nullable|string|max:20',
            'website'          => 'nullable|string|max:255',
            'address'          => 'nullable|string|max:500',
            'city'             => 'nullable|string|max:100',
            'description'      => 'nullable|string|max:2000',
            'established_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'operating_hours'  => 'nullable|string|max:100',
            'total_rooms'      => 'nullable|integer|min:0',
            'total_beds'       => 'nullable|integer|min:0',
            'icu_beds'         => 'nullable|integer|min:0',
            'logo'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $Data = $Request->only([
            'hospital_name', 'email', 'phone', 'website', 'address', 'city',
            'description', 'established_year', 'operating_hours',
            'total_rooms', 'total_beds', 'icu_beds',
        ]);

        $Data['emergency_available'] = $Request->has('emergency_available');
        $Data['ambulance_available'] = $Request->has('ambulance_available');

        if ($Request->hasFile('logo')) {
            if ($Hospital->logo && file_exists(public_path($Hospital->logo))) {
                unlink(public_path($Hospital->logo));
            }

            $UploadDir = public_path('uploads/hospitals');
            if (!is_dir($UploadDir)) {
                mkdir($UploadDir, 0755, true);
            }

            $LogoFile = $Request->file('logo');
            $LogoName = 'hospital_' . $Hospital->id . '_' . time() . '.' . $LogoFile->getClientOriginalExtension();
            $LogoFile->move($UploadDir, $LogoName);
            $Data['logo'] = 'uploads/hospitals/' . $LogoName;
        }

        $JsonFields = [
            'doctors_json'         => 'doctors_list',
            'special_doctors_json' => 'special_doctors',
            'specialties_json'     => 'specialties',
            'facilities_json'      => 'facilities',
            'medicines_json'       => 'medicines',
        ];

        foreach ($JsonFields as $InputKey => $Column) {
            if ($Request->filled($InputKey)) {
                $Decoded = json_decode($Request->input($InputKey), true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    return back()->withErrors([
                        $InputKey => 'Invalid JSON for ' . str_replace('_json', '', $InputKey) . '.',
                    ])->withInput();
                }

                $Data[$Column] = $Decoded;
            }
        }

        if ($Request->filled('reviews_json')) {
            $ReviewsArray = json_decode($Request->input('reviews_json'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['reviews_json' => 'Invalid reviews data.'])->withInput();
            }

            $Data['reviews'] = is_array($ReviewsArray) ? $ReviewsArray : [];

            if (is_array($ReviewsArray) && count($ReviewsArray) > 0) {
                $TotalRating           = array_sum(array_map('floatval', array_column($ReviewsArray, 'rating')));
                $Data['rating']        = round($TotalRating / count($ReviewsArray), 1);
                $Data['total_reviews'] = count($ReviewsArray);
            } else {
                
                $Data['rating']        = 0;
                $Data['total_reviews'] = 0;
            }
        }

        $Data['profile_completed'] = true;

        $Hospital->update($Data);

        return back()->with('success', 'Hospital profile updated successfully.');
    }

    public function deleteProfile()
    {
        $Hospital = $this->getHospital();

        if ($Hospital->logo && file_exists(public_path($Hospital->logo))) {
            unlink(public_path($Hospital->logo));
        }

        $Hospital->update([
            'logo'                => null,
            'email'               => null,
            'website'             => null,
            'established_year'    => null,
            'operating_hours'     => null,
            'total_rooms'         => 0,
            'total_beds'          => 0,
            'icu_beds'            => 0,
            'emergency_available' => false,
            'ambulance_available' => false,
            'doctors_list'        => null,
            'special_doctors'     => null,
            'specialties'         => null,
            'facilities'          => null,
            'medicines'           => null,
            'rating'              => 0,
            'total_reviews'       => 0,
            'reviews'             => null,
            'profile_completed'   => false,
        ]);

        return redirect('/Hospital/Profile')->with('success', 'Profile data has been reset.');
    }
}