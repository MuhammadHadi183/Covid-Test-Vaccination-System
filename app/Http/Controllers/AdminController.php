<?php

namespace App\Http\Controllers;

use App\Mail\HospitalApprovedMail;
use App\Mail\HospitalRejectedMail;
use App\Models\Appointment;
use App\Models\CovidTest;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\PatientRequest;
use App\Models\User;
use App\Models\Vaccine;
use App\Models\VaccineStock;
use App\Models\VaccinationRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        $TotalPatients = Patient::count();
        $TotalHospitals = Hospital::where('status', 'approved')->count();
        $TotalVaccinated = VaccinationRecord::where('status', 'completed')->count();
        $TotalTests = CovidTest::count();
        $PositiveTests = CovidTest::where('result', 'positive')->count();
        $PendingHospitals = Hospital::where('status', 'pending')->count();
        $PendingRequests = PatientRequest::where('status', 'pending')->count();
        $RecentPatients = Patient::with('user')->latest()->take(7)->get();
        $RecentTests = CovidTest::with(['patient.user', 'hospital'])->latest()->take(6)->get();
        $TodayAppointments = Appointment::with(['patient.user', 'hospital'])
            ->whereDate('appointment_date', today())->orderBy('time_slot')->take(7)->get();
        $Vaccines = Vaccine::all();

        return view('admin.dashboard', compact(
            'TotalPatients',
            'TotalHospitals',
            'TotalVaccinated',
            'TotalTests',
            'PositiveTests',
            'PendingHospitals',
            'PendingRequests',
            'RecentPatients',
            'RecentTests',
            'TodayAppointments',
            'Vaccines'
        ));
    }

    public function patients(Request $Request)
    {
        $Query = Patient::with('user');
        if ($Request->search) {
            $Search = $Request->search;
            $Query->whereHas('user', function ($Q) use ($Search) {
                $Q->where('name', 'like', "%{$Search}%")->orWhere('email', 'like', "%{$Search}%");
            })->orWhere('cnic', 'like', "%{$Search}%");
        }
        $Patients = $Query->latest()->paginate(15);
        return view('admin.patients', compact('Patients'));
    }

    public function createPatient()
    {
        return view('admin.patients-create');
    }

    public function storePatient(Request $Request)
    {
        $Request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'cnic' => 'nullable|string|max:15',
            'city' => 'nullable|string|max:100',
            'blood_group' => 'nullable|string|max:5',
        ]);

        $User = User::create([
            'name' => $Request->name,
            'email' => $Request->email,
            'password' => Hash::make($Request->password),
            'role' => 'patient',
            'status' => 'approved',
            'phone' => $Request->phone,
            'city' => $Request->city,
        ]);

        Patient::create([
            'user_id' => $User->id,
            'gender' => $Request->gender,
            'cnic' => $Request->cnic,
            'city' => $Request->city,
            'blood_group' => $Request->blood_group,
        ]);

        return redirect('/Admin/Patients')->with('success', 'Patient created successfully.');
    }

    public function editPatient($Id)
    {
        $Patient = Patient::with('user')->findOrFail($Id);
        return view('admin.patients-edit', compact('Patient'));
    }

    public function updatePatient(Request $Request, $Id)
    {
        $Patient = Patient::findOrFail($Id);
        $Request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'cnic' => 'nullable|string|max:15',
            'city' => 'nullable|string|max:100',
            'blood_group' => 'nullable|string|max:5',
        ]);

        $Patient->user->update(['name' => $Request->name, 'phone' => $Request->phone]);
        $Patient->update([
            'gender' => $Request->gender,
            'cnic' => $Request->cnic,
            'city' => $Request->city,
            'blood_group' => $Request->blood_group,
        ]);

        return redirect('/Admin/Patients')->with('success', 'Patient updated.');
    }

    public function deletePatient($Id)
    {
        $Patient = Patient::findOrFail($Id);
        $Patient->user->delete();
        return redirect('/Admin/Patients')->with('success', 'Patient deleted.');
    }

    public function reports()
    {
        $AllPatients = Patient::with('user')->get();
        return view('admin.reports', compact('AllPatients'));
    }

    public function generateReport($Id)
    {
        $Patient = Patient::with('user')->findOrFail($Id);
        $Hospitals = Hospital::where('status', 'approved')->orderBy('hospital_name')->get();
        return view('admin.report-form', compact('Patient', 'Hospitals'));
    }

    public function submitReport(Request $Request, $Id)
    {
        $Request->validate([
            'report_type' => 'required|in:covid_test,vaccination,full',
            'test_type' => 'nullable|in:PCR,Antigen RAT',
            'result' => 'nullable|in:pending,positive,negative',
            'ct_value' => 'nullable|numeric',
            'covid_hospital_id' => 'nullable|exists:hospitals,id',
            'vaccine_hospital_id' => 'nullable|exists:hospitals,id',
            'vaccine_id' => 'nullable|exists:vaccines,id',
            'dose_number' => 'nullable|integer|min:1',
            'vaccination_status' => 'nullable|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $PatientId = $Id;

        if ($Request->report_type === 'covid_test' || $Request->report_type === 'full') {
            if ($Request->test_type && $Request->covid_hospital_id) {
                CovidTest::create([
                    'patient_id' => $PatientId,
                    'hospital_id' => $Request->covid_hospital_id,
                    'test_type' => $Request->test_type,
                    'result' => $Request->result ?? 'pending',
                    'ct_value' => $Request->ct_value,
                    'tested_at' => now(),
                ]);
            }
        }

        if ($Request->report_type === 'vaccination' || $Request->report_type === 'full') {
            if ($Request->vaccine_id && $Request->vaccine_hospital_id) {
                VaccinationRecord::create([
                    'patient_id' => $PatientId,
                    'hospital_id' => $Request->vaccine_hospital_id,
                    'vaccine_id' => $Request->vaccine_id,
                    'dose_number' => $Request->dose_number ?? 1,
                    'status' => $Request->vaccination_status ?? 'scheduled',
                    'vaccinated_at' => $Request->vaccination_status === 'completed' ? now() : null,
                ]);
            }
        }

        return redirect("/Admin/Reports/View/{$PatientId}")->with('success', 'Report generated successfully.');
    }

    public function viewReport($Id)
    {
        $Patient = Patient::with('user')->findOrFail($Id);
        $Tests = CovidTest::with('hospital')->where('patient_id', $Id)->latest()->get();
        $Vaccinations = VaccinationRecord::with(['hospital', 'vaccine'])->where('patient_id', $Id)->latest()->get();
        $Appointments = Appointment::with('hospital')->where('patient_id', $Id)->latest()->get();
        return view('admin.patient-report', compact('Patient', 'Tests', 'Vaccinations', 'Appointments'));
    }

    public function exportReport(Request $Request)
    {
        $Filter = $Request->filter ?? 'daily';
        $Date = $Request->date ?? today()->toDateString();
        $TestsQuery = CovidTest::with(['patient.user', 'hospital']);

        if ($Filter === 'daily') {
            $TestsQuery->whereDate('created_at', $Date);
        } elseif ($Filter === 'weekly') {
            $TestsQuery->whereBetween('created_at', [now()->parse($Date)->startOfWeek(), now()->parse($Date)->endOfWeek()]);
        } elseif ($Filter === 'monthly') {
            $TestsQuery->whereMonth('created_at', now()->parse($Date)->month)->whereYear('created_at', now()->parse($Date)->year);
        }

        $Tests = $TestsQuery->latest()->get();
        $FileName = "covid_report_{$Filter}_{$Date}.csv";
        $Headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$FileName}\""];
        $Callback = function () use ($Tests) {
            $File = fopen('php://output', 'w');
            fputcsv($File, ['Patient Name', 'Test Type', 'Result', 'CT Value', 'Hospital', 'Date']);
            foreach ($Tests as $T) {
                fputcsv($File, [$T->patient->user->name ?? 'N/A', $T->test_type, $T->result, $T->ct_value ?? 'N/A', $T->hospital->hospital_name ?? 'N/A', $T->created_at->format('Y-m-d H:i')]);
            }
            fclose($File);
        };
        return response()->stream($Callback, 200, $Headers);
    }

    public function vaccines()
    {
        $Vaccines = Vaccine::withCount([
            'stocks as total_stock' => function ($Q) {
                $Q->select(\DB::raw('COALESCE(SUM(quantity), 0)'));
            }
        ])->get();

        foreach ($Vaccines as $V) {
            $NewStatus = $V->total_stock > 0 ? 'available' : 'unavailable';
            if ($V->status !== $NewStatus) {
                $V->update(['status' => $NewStatus]);
            }
        }

        return view('admin.vaccines', compact('Vaccines'));
    }

    public function createVaccine()
    {
        return view('admin.vaccines-create');
    }

    public function storeVaccine(Request $Request)
    {
        $Request->validate(['name' => 'required', 'manufacturer' => 'required', 'doses_required' => 'required|integer|min:1']);
        $Data = $Request->only('name', 'manufacturer', 'doses_required', 'description');
        $Data['status'] = 'unavailable';
        Vaccine::create($Data);
        return redirect('/Admin/Vaccines')->with('success', 'Vaccine created.');
    }

    public function editVaccine($Id)
    {
        $Vaccine = Vaccine::with(['stocks.hospital'])->findOrFail($Id);
        $Hospitals = Hospital::where('status', 'approved')->orderBy('hospital_name')->get();

        return view('admin.vaccines-edit', compact('Vaccine', 'Hospitals'));
    }

    public function storeVaccineStock(Request $Request, $Id)
    {
        $Vaccine = Vaccine::findOrFail($Id);
        $Request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'quantity' => 'required|integer|min:1',
            'expiry_date' => 'nullable|date',
        ]);

        $Stock = VaccineStock::firstOrNew(
            [
                'hospital_id' => $Request->hospital_id,
                'vaccine_id' => $Vaccine->id,
            ],
            ['quantity' => 0]
        );
        $Stock->quantity = (int) $Stock->quantity + (int) $Request->quantity;
        if ($Request->filled('expiry_date')) {
            $Stock->expiry_date = $Request->expiry_date;
        }
        $Stock->save();

        $TotalStock = $Vaccine->stocks()->sum('quantity');
        $Vaccine->update(['status' => $TotalStock > 0 ? 'available' : 'unavailable']);

        return back()->with('success', 'Stock added for the selected hospital.');
    }

    public function updateVaccine(Request $Request, $Id)
    {
        $Request->validate(['name' => 'required', 'manufacturer' => 'required', 'doses_required' => 'required|integer|min:1']);
        $Vaccine = Vaccine::findOrFail($Id);
        $Vaccine->update($Request->only('name', 'manufacturer', 'doses_required', 'description'));

        $TotalStock = $Vaccine->stocks()->sum('quantity');
        $Vaccine->update(['status' => $TotalStock > 0 ? 'available' : 'unavailable']);

        return redirect('/Admin/Vaccines')->with('success', 'Vaccine updated.');
    }

    public function deleteVaccine($Id)
    {
        Vaccine::findOrFail($Id)->delete();
        return redirect('/Admin/Vaccines')->with('success', 'Vaccine deleted.');
    }

    public function hospitals(Request $Request)
    {
        $Tab = $Request->query('tab', 'directory');
        $Status = $Request->status ?? 'all';
        $Query = Hospital::with('user');

        if ($Tab === 'directory') {
            $Query->where('status', 'approved')->where('profile_completed', true);
        } elseif ($Tab === 'pending') {
            $Query->where('status', 'pending');
        } elseif ($Status !== 'all') {
            $Query->where('status', $Status);
        }

        $Hospitals = $Query->latest()->paginate(15)->withQueryString();

        return view('admin.hospitals', compact('Hospitals', 'Status', 'Tab'));
    }

    public function approveHospitalSigned(Request $Request, $Id)
    {
        $Hospital = Hospital::with('user')->findOrFail($Id);
        if ($Hospital->status === 'approved') {
            return redirect('/')->with('success', 'This hospital is already approved.');
        }

        $Hospital->update(['status' => 'approved']);
        $Hospital->user->update(['status' => 'approved']);


        Mail::to($Hospital->user->email)->send(new HospitalApprovedMail($Hospital));


        return redirect('/')->with('success', 'Hospital approved successfully.');
    }

    public function approveHospital($Id)
    {
        $Hospital = Hospital::with('user')->findOrFail($Id);
        $Hospital->update(['status' => 'approved']);
        $Hospital->user->update(['status' => 'approved']);

        
            Mail::to($Hospital->user->email)->send(new HospitalApprovedMail($Hospital));
       

        return back()->with('success', 'Hospital approved.');
    }

    public function rejectHospital($Id)
    {
        $Hospital = Hospital::with('user')->findOrFail($Id);
        $Hospital->update(['status' => 'rejected']);
        $Hospital->user->update(['status' => 'rejected']);


        Mail::to($Hospital->user->email)->send(new HospitalRejectedMail($Hospital));


        return back()->with('success', 'Hospital rejected.');
    }

    public function deleteHospital($Id)
    {
        Hospital::findOrFail($Id)->user->delete();
        return redirect('/Admin/Hospitals')->with('success', 'Hospital deleted.');
    }

    public function hospitalDetails($Id)
    {
        $Hospital = Hospital::with('user')->findOrFail($Id);
        $TotalPatients = PatientRequest::where('hospital_id', $Id)
            ->where('status', 'approved')->distinct('patient_id')->count('patient_id');
        $TotalTests = CovidTest::where('hospital_id', $Id)->count();
        $TotalVaccinations = VaccinationRecord::where('hospital_id', $Id)
            ->where('status', 'completed')->count();
        $TotalAppointments = Appointment::where('hospital_id', $Id)->count();

        return view('admin.hospital-details', compact(
            'Hospital',
            'TotalPatients',
            'TotalTests',
            'TotalVaccinations',
            'TotalAppointments'
        ));
    }

    public function bookings(Request $Request)
    {
        $Query = Appointment::with(['patient.user', 'hospital']);
        if ($Request->status && $Request->status !== 'all') {
            $Query->where('status', $Request->status);
        }
        $Bookings = $Query->latest()->paginate(15);
        return view('admin.bookings', compact('Bookings'));
    }

    public function updateBookingStatus(Request $Request, $Id)
    {
        $Request->validate([
            'status' => ['required', Rule::in(['pending', 'confirmed', 'completed', 'cancelled'])],
            'cancel_reason' => ['required_if:status,cancelled', 'nullable', 'string', 'max:2000'],
        ]);
        $Data = ['status' => $Request->status];
        $Data['cancel_reason'] = $Request->status === 'cancelled' ? $Request->input('cancel_reason') : null;
        Appointment::findOrFail($Id)->update($Data);

        return back()->with('success', 'Booking status updated.');
    }

    public function deleteBooking($Id)
    {
        Appointment::findOrFail($Id)->delete();
        return redirect('/Admin/Bookings')->with('success', 'Booking deleted.');
    }
}
