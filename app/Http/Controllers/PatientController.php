<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\CovidTest;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\PatientRequest;
use App\Models\VaccinationRecord;
use App\Models\Vaccine;
use App\Mail\AppointmentBookedMail;
use App\Mail\PatientRequestToHospitalMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
     function getPatient()
    {
        return Patient::firstOrCreate(
            ['user_id' => auth()->id()]
        );
    }

    public function dashboard()
    {
        $Patient = $this->getPatient();
        $UpcomingAppointments = Appointment::with('hospital')
            ->where('patient_id', $Patient->id)
            ->where('appointment_date', '>=', today())
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->take(5)->get();
        $RecentResults = CovidTest::with('hospital')
            ->where('patient_id', $Patient->id)
            ->latest()->take(3)->get();
        $VaccinationRecords = VaccinationRecord::with(['hospital', 'vaccine'])
            ->where('patient_id', $Patient->id)
            ->where('status', 'completed')
            ->get();
        $PendingRequests = PatientRequest::with('hospital')
            ->where('patient_id', $Patient->id)
            ->where('status', 'pending')
            ->count();

        return view('patient.dashboard', compact(
            'Patient', 'UpcomingAppointments', 'RecentResults',
            'VaccinationRecords', 'PendingRequests'
        ));
    }

    public function searchHospitals(Request $Request)
    {
        $Query = Hospital::publicProfile();

        if ($Request->city) {
            $Query->where('city', 'like', "%{$Request->city}%");
        }
        if ($Request->search) {
            $Query->where('hospital_name', 'like', "%{$Request->search}%");
        }

        $Hospitals = $Query->with('vaccineStocks.vaccine')->paginate(12);
        return view('patient.search-hospitals', compact('Hospitals'));
    }

    public function showHospital($Id)
    {
        $Hospital = Hospital::publicProfile()
            ->with(['vaccineStocks.vaccine', 'user'])
            ->findOrFail($Id);

        return view('patient.hospital-show', compact('Hospital'));
    }

    public function submitRequest(Request $Request)
    {
        $Request->validate([
            'hospital_id' => [
                'required',
                Rule::exists('hospitals', 'id')->where(fn ($q) => $q->where('status', 'approved')->where('profile_completed', true)),
            ],
            'request_type' => 'required|in:covid_test,vaccination',
            'message' => 'nullable|string|max:500',
        ]);

        $Patient = $this->getPatient();

        $PatientRequest = PatientRequest::create([
            'patient_id' => $Patient->id,
            'hospital_id' => $Request->hospital_id,
            'request_type' => $Request->request_type,
            'message' => $Request->message,
        ]);

        $PatientRequest->load(['patient.user', 'hospital.user']);
        
            if ($PatientRequest->hospital?->user?->email) {
                Mail::to($PatientRequest->hospital->user->email)->send(new PatientRequestToHospitalMail($PatientRequest));
            }
       

        return back()->with('success', 'Request submitted successfully.');
    }

    public function reports()
    {
        $Patient = $this->getPatient();
        $Tests = CovidTest::with('hospital')
            ->where('patient_id', $Patient->id)
            ->latest()->get();
        $Vaccinations = VaccinationRecord::with(['hospital', 'vaccine'])
            ->where('patient_id', $Patient->id)
            ->latest()->get();

        return view('patient.reports', compact('Tests', 'Vaccinations'));
    }

    public function bookAppointment()
    {
        $Hospitals = Hospital::publicProfile()->orderBy('hospital_name')->get();
        return view('patient.book-appointment', compact('Hospitals'));
    }

    public function storeAppointment(Request $Request)
    {
        $Request->validate([
            'hospital_id' => [
                'required',
                Rule::exists('hospitals', 'id')->where(fn ($q) => $q->where('status', 'approved')->where('profile_completed', true)),
            ],
            'type' => 'required|in:covid_test,vaccination',
            'appointment_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string',
            'notes' => 'nullable|string|max:500',
        ]);

        $Patient = $this->getPatient();

        $Appointment = Appointment::create([
            'patient_id' => $Patient->id,
            'hospital_id' => $Request->hospital_id,
            'type' => $Request->type,
            'appointment_date' => $Request->appointment_date,
            'time_slot' => $Request->time_slot,
            'notes' => $Request->notes,
        ]);

        $Appointment->load(['patient.user', 'hospital.user']);
       
            if (auth()->user()->email) {
                Mail::to(auth()->user()->email)->send(new AppointmentBookedMail($Appointment, 'patient'));
            }
            if ($Appointment->hospital?->user?->email) {
                Mail::to($Appointment->hospital->user->email)->send(new AppointmentBookedMail($Appointment, 'hospital'));
            }
        

        return redirect('/Patient/Appointments')->with('success', 'Appointment booked successfully!');
    }

    public function myAppointments()
    {
        $Patient = $this->getPatient();
        $Appointments = Appointment::with('hospital')
            ->where('patient_id', $Patient->id)
            ->latest()->paginate(15);

        return view('patient.appointments', compact('Appointments'));
    }

    public function myRequests()
    {
        $Patient = $this->getPatient();
        $Requests = PatientRequest::with('hospital')
            ->where('patient_id', $Patient->id)
            ->latest()->paginate(15);

        return view('patient.requests', compact('Requests'));
    }

   

    public function profile()
    {
        $Patient = $this->getPatient();
        return view('patient.profile', compact('Patient'));
    }

    public function updateProfile(Request $Request)
    {
        $Request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'emergency_contact' => 'nullable|string|max:20',
        ]);

        $User = auth()->user();
        $User->update([
            'name' => $Request->name,
            'phone' => $Request->phone,
        ]);

        $User->patient->update([
            'dob' => $Request->dob,
            'gender' => $Request->gender,
            'blood_group' => $Request->blood_group,
            'address' => $Request->address,
            'city' => $Request->city,
            'emergency_contact' => $Request->emergency_contact,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }


    public function SearchHospitalFilter(Request $Request){
        $Query = Hospital::publicProfile();

        if ($Request->DataName) {
            $Query->where('hospital_name', 'like', "%{$Request->DataName}%");
        }
        if ($Request->DataCity) {
            $Query->where('city', 'like', "%{$Request->DataCity}%");
        }

        $Data = $Query->with('vaccineStocks.vaccine')->get();
        return response()->json($Data);
    }
}

