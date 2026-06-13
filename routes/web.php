<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReportController;
Route::get('/',function(){
    return view('auth.register');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});

Route::get('/Admin/Hospitals/{Id}/Approve-Link', [AdminController::class, 'approveHospitalSigned'])
    ->middleware(['signed'])
    ->name('admin.hospital.approve-link');


Route::middleware(['auth'])->group(function () {
    Route::get('/Dashboard', function () {
        $Role = auth()->user()->role;
        if ($Role === 'admin') {
            return redirect('/Admin/Dashboard');
        }
        if ($Role === 'hospital') {
            return redirect('/Hospital/Dashboard');
        }

        return redirect('/Patient/Dashboard');
    })->name('dashboard');

    Route::get('/Admin/Dashboard', [AdminController::class, 'dashboard']);
    Route::get('/Admin/Patients', [AdminController::class, 'patients']);
    Route::get('/Admin/Patients/Create', [AdminController::class, 'createPatient']);
    Route::post('/Admin/Patients/Store', [AdminController::class, 'storePatient']);
    Route::get('/Admin/Patients/{Id}/Edit', [AdminController::class, 'editPatient']);
    Route::post('/Admin/Patients/{Id}/Update', [AdminController::class, 'updatePatient']);
    Route::post('/Admin/Patients/{Id}/Delete', [AdminController::class, 'deletePatient']);
    Route::get('/Admin/Reports', [AdminController::class, 'reports']);
    Route::get('/Admin/Reports/Generate/{Id}', [AdminController::class, 'generateReport']);
    Route::post('/Admin/Reports/Generate/{Id}', [AdminController::class, 'submitReport']);
    Route::get('/Admin/Reports/View/{Id}', [AdminController::class, 'viewReport']);
    Route::get('/Admin/Vaccines', [AdminController::class, 'vaccines']);
    Route::get('/Admin/Vaccines/Create', [AdminController::class, 'createVaccine']);
    Route::post('/Admin/Vaccines/Store', [AdminController::class, 'storeVaccine']);
    Route::get('/Admin/Vaccines/{Id}/Edit', [AdminController::class, 'editVaccine']);
    Route::post('/Admin/Vaccines/{Id}/Update', [AdminController::class, 'updateVaccine']);
    Route::post('/Admin/Vaccines/{Id}/Stock', [AdminController::class, 'storeVaccineStock']);
    Route::post('/Admin/Vaccines/{Id}/Delete', [AdminController::class, 'deleteVaccine']);
    Route::get('/Admin/Hospitals', [AdminController::class, 'hospitals']);
    Route::get('/Admin/Hospitals/{Id}/Details', [AdminController::class, 'hospitalDetails']);
    Route::post('/Admin/Hospitals/{Id}/Approve', [AdminController::class, 'approveHospital']);
    Route::post('/Admin/Hospitals/{Id}/Reject', [AdminController::class, 'rejectHospital']);
    Route::post('/Admin/Hospitals/{Id}/Delete', [AdminController::class, 'deleteHospital']);
    Route::get('/Admin/Bookings', [AdminController::class, 'bookings']);
    Route::post('/Admin/Bookings/{Id}/Status', [AdminController::class, 'updateBookingStatus']);
    Route::post('/Admin/Bookings/{Id}/Delete', [AdminController::class, 'deleteBooking']);

    Route::get('/Admin/Security/2FA', [\App\Http\Controllers\TwoFactorSetupController::class, 'index'])->name('admin.setup-2fa');
    Route::post('/Admin/Security/2FA/Switch', [\App\Http\Controllers\TwoFactorSetupController::class, 'switchMethod'])->name('admin.setup-2fa.switch');
    
    Route::get('/Admin/Security/Email-Challenge', [\App\Http\Controllers\TwoFactorSetupController::class, 'showEmailChallenge'])->name('admin.2fa.email.challenge');
    Route::post('/Admin/Security/Email-Challenge', [\App\Http\Controllers\TwoFactorSetupController::class, 'verifyEmailChallenge'])->name('admin.2fa.email.verify');
    Route::get('/Admin/Security/Email-Challenge/Resend', [\App\Http\Controllers\TwoFactorSetupController::class, 'resendEmailCode'])->name('admin.2fa.email.resend');

    Route::get('/Hospital/Dashboard', [HospitalController::class, 'dashboard']);
    Route::get('/Hospital/Patients', [HospitalController::class, 'patients']);
    Route::get('/Hospital/Requests', [HospitalController::class, 'requests']);
    Route::post('/Hospital/Requests/{Id}/Approve', [HospitalController::class, 'approveRequest']);
    Route::post('/Hospital/Requests/{Id}/Reject', [HospitalController::class, 'rejectRequest']);
    Route::get('/Hospital/Appointments', [HospitalController::class, 'appointments']);
    Route::post('/Hospital/Appointments/{Id}/Status', [HospitalController::class, 'updateAppointmentStatus']);
    Route::get('/Hospital/Vaccine-Stock', [HospitalController::class, 'vaccineStocks']);
    Route::post('/Hospital/Vaccine-Catalog', [HospitalController::class, 'storeHospitalVaccine']);
    Route::post('/Hospital/Vaccine-Stock', [HospitalController::class, 'storeVaccineStock']);
    Route::post('/Hospital/Vaccine-Stock/{Id}/Update', [HospitalController::class, 'updateVaccineStock']);
    Route::post('/Hospital/Vaccine-Stock/{Id}/Delete', [HospitalController::class, 'deleteVaccineStock']);
    Route::get('/Hospital/Covid-Results', [HospitalController::class, 'covidResults']);
    Route::post('/Hospital/Covid-Results', [HospitalController::class, 'storeCovidResult']);
    Route::post('/Hospital/Covid-Results/{Id}/Update', [HospitalController::class, 'updateResult']);
    Route::get('/Hospital/Vaccinations', [HospitalController::class, 'vaccinations']);
    Route::post('/Hospital/Vaccinations', [HospitalController::class, 'storeVaccination']);
    Route::post('/Hospital/Vaccinations/{Id}/Update', [HospitalController::class, 'updateVaccination']);
    Route::get('/Hospital/Profile', [HospitalController::class, 'profile']);
    Route::post('/Hospital/Profile', [HospitalController::class, 'updateProfile']);
    Route::post('/Hospital/Profile/Delete', [HospitalController::class, 'deleteProfile']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/Patient/Dashboard', [PatientController::class, 'dashboard']);
    Route::get('/Patient/Search-Hospitals/', [PatientController::class, 'searchHospitals']);
    Route::get('/Filter', [PatientController::class, 'SearchHospitalFilter']);
    Route::get('/Patient/Hospitals/{Id}', [PatientController::class, 'showHospital']);
    Route::post('/Patient/Request', [PatientController::class, 'submitRequest']);
    Route::get('/Patient/Reports', [PatientController::class, 'reports']);
    Route::get('/Patient/Book-Appointment', [PatientController::class, 'bookAppointment']);
    Route::post('/Patient/Book-Appointment', [PatientController::class, 'storeAppointment']);
    Route::get('/Patient/Appointments', [PatientController::class, 'myAppointments']);
    Route::get('/Patient/Requests', [PatientController::class, 'myRequests']);
    Route::get('/Patient/Profile', [PatientController::class, 'profile']);
    Route::post('/Patient/Profile', [PatientController::class, 'updateProfile']);
});


Route::get('/Admin/Reports/Export', [ReportController::class, 'exportExcel'])->name('report.export');
