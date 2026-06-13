<table>



    <tr>
        <td colspan="12"
            style="font-weight:bold;font-size:16px;background-color:#1A3C5E;color:#FFFFFF;padding:6px 8px;">
            📅 Appointments
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Appointment ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Patient ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Hospital ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Type</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Appointment Date</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Time Slot</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Status</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Notes</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Cancel Reason</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Created At</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Updated At</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Total</td>
    </tr>
    @foreach ($Appointments as $Appointment)
        <tr>
            <td style="border:1px solid #DDDDDD;">{{ $Appointment->id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Appointment->patient_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Appointment->hospital_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Appointment->type }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Appointment->appointment_date }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Appointment->time_slot }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Appointment->status }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Appointment->notes ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Appointment->cancel_reason ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Appointment->created_at }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Appointment->updated_at }}</td>
            @if ($loop->first)
                <td style="border:1px solid #DDDDDD;font-weight:bold;">{{ $Appointments->count() }}</td>
            @else
                <td style="border:1px solid #DDDDDD;"></td>
            @endif
        </tr>
    @endforeach
    <tr>
        <td colspan="12" style="height:12px;"></td>
    </tr>




    <tr>
        <td colspan="11"
            style="font-weight:bold;font-size:16px;background-color:#1A3C5E;color:#FFFFFF;padding:6px 8px;">
            🧪 Covid Tests
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Test ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Patient ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Hospital ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Test Type</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Result</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Ct Value</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Notes</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Tested At</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Created At</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Updated At</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Total</td>
    </tr>
    @foreach ($CovidTests as $CovidTest)
        <tr>
            <td style="border:1px solid #DDDDDD;">{{ $CovidTest->id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $CovidTest->patient_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $CovidTest->hospital_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $CovidTest->test_type }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $CovidTest->result }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $CovidTest->ct_value ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $CovidTest->notes ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $CovidTest->tested_at }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $CovidTest->created_at }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $CovidTest->updated_at }}</td>
            @if ($loop->first)
                <td style="border:1px solid #DDDDDD;font-weight:bold;">{{ $CovidTests->count() }}</td>
            @else
                <td style="border:1px solid #DDDDDD;"></td>
            @endif
        </tr>
    @endforeach
    <tr>
        <td colspan="11" style="height:12px;"></td>
    </tr>

   

 
    <tr>
        <td colspan="22"
            style="font-weight:bold;font-size:16px;background-color:#1A3C5E;color:#FFFFFF;padding:6px 8px;">
            🏥 Hospitals
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Hospital ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">User ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Hospital Name</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Registration No</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Address</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">City</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Phone</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Email</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Website</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Established Year</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Operating Hours</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Total Rooms</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Total Beds</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">ICU Beds</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Emergency Available</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Ambulance Available</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Status</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Rating</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Total Reviews</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Specialties</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Facilities</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Description</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Total</td>
    </tr>
    @foreach ($Hospitals as $Hospital)
        @php
            $Doctors = collect($Hospital->doctors_list ?? []);
            $SpecialDoctors = collect($Hospital->special_doctors ?? []);
        @endphp
        <tr>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->user_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->hospital_name }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->registration_no }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->address }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->city }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->phone }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->email }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->website ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->established_year ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->operating_hours ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->total_rooms ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->total_beds ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->icu_beds ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->emergency_available ? 'Yes' : 'No' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->ambulance_available ? 'Yes' : 'No' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->status }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->rating ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->total_reviews ?? 0 }}</td>
            <td style="border:1px solid #DDDDDD;">{{ collect($Hospital->specialties ?? [])->implode(', ') ?: '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ collect($Hospital->facilities ?? [])->implode(', ') ?: '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->description ?? '—' }}</td>
            @if ($loop->first)
                <td style="border:1px solid #DDDDDD;font-weight:bold;">{{ $Hospitals->count() }}</td>
            @else
                <td style="border:1px solid #DDDDDD;"></td>
            @endif
        </tr>
    @endforeach
    <tr>
        <td colspan="22" style="height:12px;"></td>
    </tr>

   

  
    <tr>
        <td colspan="6" style="font-weight:bold;font-size:16px;background-color:#2E6DA4;color:#FFFFFF;padding:6px 8px;">
            👨‍⚕️ Doctors 
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Hospital ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Hospital Name</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Doctor Name</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Specialty</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Qualification</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Phone</td>
    </tr>
    @foreach ($Hospitals as $Hospital)
        @php $Doctors = collect($Hospital->doctors_list ?? []); @endphp
        <tr>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->hospital_name }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Doctors->implode('name', ', ') ? : '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Doctors->implode('specialty', ', ') ?: '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Doctors->implode('qualification', ', ') ?: '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Doctors->implode('phone', ', ') ? : '—' }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="6" style="height:12px;"></td>
    </tr>

    

   
    <tr>
        <td colspan="6" style="font-weight:bold;font-size:16px;background-color:#2E6DA4;color:#FFFFFF;padding:6px 8px;">
            🩺 Special Doctors 
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Hospital ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Hospital Name</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Doctor Name</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Specialty</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Qualification</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Phone</td>
    </tr>
    @foreach ($Hospitals as $Hospital)
        @php $SpecialDoctors = collect($Hospital->special_doctors ?? []); @endphp
        <tr>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Hospital->hospital_name }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $SpecialDoctors->implode('name', ', ') ?: '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $SpecialDoctors->implode('specialty', ', ') ?: '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $SpecialDoctors->implode('qualification', ', ') ?: '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $SpecialDoctors->implode('phone', ', ') ?: '—' }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="6" style="height:12px;"></td>
    </tr>

  


    <tr>
        <td colspan="11"
            style="font-weight:bold;font-size:16px;background-color:#1A3C5E;color:#FFFFFF;padding:6px 8px;">
            🧑‍⚕️ Patients
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Patient ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">User ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Date of Birth</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Gender</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">CNIC</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Blood Group</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Address</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">City</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Emergency Contact</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Created At</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Total</td>
    </tr>
    @foreach ($Patients as $Patient)
        <tr>
            <td style="border:1px solid #DDDDDD;">{{ $Patient->id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Patient->user_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Patient->dob ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Patient->gender ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Patient->cnic?? '—'  }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Patient->blood_group ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Patient->address ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Patient->city ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Patient->emergency_contact ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Patient->created_at }}</td>
            @if ($loop->first)
                <td style="border:1px solid #DDDDDD;font-weight:bold;">{{ $Patients->count() }}</td>
            @else
                <td style="border:1px solid #DDDDDD;"></td>
            @endif
        </tr>
    @endforeach
    <tr>
        <td colspan="11" style="height:12px;"></td>
    </tr>

   

    
    <tr>
        <td colspan="8" style="font-weight:bold;font-size:16px;background-color:#1A3C5E;color:#FFFFFF;padding:6px 8px;">
            📋 Patient Requests
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Request ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Patient ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Hospital ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Request Type</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Status</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Message</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Admin Notes</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Total</td>
    </tr>
    @foreach ($PatientRequests as $PatientRequest)
        <tr>
            <td style="border:1px solid #DDDDDD;">{{ $PatientRequest->id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $PatientRequest->patient_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $PatientRequest->hospital_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $PatientRequest->request_type }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $PatientRequest->status }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $PatientRequest->message ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $PatientRequest->admin_notes ?? '—' }}</td>
            @if ($loop->first)
                <td style="border:1px solid #DDDDDD;font-weight:bold;">{{ $PatientRequests->count() }}</td>
            @else
                <td style="border:1px solid #DDDDDD;"></td>
            @endif
        </tr>
    @endforeach
    <tr>
        <td colspan="8" style="height:12px;"></td>
    </tr>

 

    <tr>
        <td colspan="10"
            style="font-weight:bold;font-size:16px;background-color:#1A3C5E;color:#FFFFFF;padding:6px 8px;">
            👤 Users
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">User ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Name</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Email</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Role</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Phone</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Address</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">City</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Status</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Email Verified At</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Total</td>
    </tr>
    @foreach ($Users as $User)
        <tr>
            <td style="border:1px solid #DDDDDD;">{{ $User->id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $User->name }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $User->email }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $User->role }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $User->phone ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $User->address ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $User->city ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $User->status }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $User->email_verified_at ?? 'Not Verified' }}</td>
            @if ($loop->first)
                <td style="border:1px solid #DDDDDD;font-weight:bold;">{{ $Users->count() }}</td>
            @else
                <td style="border:1px solid #DDDDDD;"></td>
            @endif
        </tr>
    @endforeach
    <tr>
        <td colspan="10" style="height:12px;"></td>
    </tr>


    <tr>
        <td colspan="11"
            style="font-weight:bold;font-size:16px;background-color:#1A3C5E;color:#FFFFFF;padding:6px 8px;">
            💉 Vaccination Records
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Record ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Patient ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Hospital ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Appointment ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Vaccine ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Dose Number</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Status</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Vaccinated At</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Notes</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Created At</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Total</td>
    </tr>
    @foreach ($VaccinationRecords as $VaccinationRecord)
        <tr>
            <td style="border:1px solid #DDDDDD;">{{ $VaccinationRecord->id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccinationRecord->patient_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccinationRecord->hospital_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccinationRecord->appointment_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccinationRecord->vaccine_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccinationRecord->dose_number }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccinationRecord->status }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccinationRecord->vaccinated_at }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccinationRecord->notes ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccinationRecord->created_at }}</td>
            @if ($loop->first)
                <td style="border:1px solid #DDDDDD;font-weight:bold;">{{ $VaccinationRecords->count() }}</td>
            @else
                <td style="border:1px solid #DDDDDD;"></td>
            @endif
        </tr>
    @endforeach
    <tr>
        <td colspan="11" style="height:12px;"></td>
    </tr>


    <tr>
        <td colspan="8" style="font-weight:bold;font-size:16px;background-color:#1A3C5E;color:#FFFFFF;padding:6px 8px;">
            🔬 Vaccines
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Vaccine ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Hospital ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Name</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Manufacturer</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Doses Required</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Status</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Description</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Total</td>
    </tr>
    @foreach ($Vaccines as $Vaccine)
        <tr>
            <td style="border:1px solid #DDDDDD;">{{ $Vaccine->id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Vaccine->hospital_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Vaccine->name }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Vaccine->manufacturer ?? '—' }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Vaccine->doses_required }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Vaccine->status }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $Vaccine->description ?? '—' }}</td>
            @if ($loop->first)
                <td style="border:1px solid #DDDDDD;font-weight:bold;">{{ $Vaccines->count() }}</td>
            @else
                <td style="border:1px solid #DDDDDD;"></td>
            @endif
        </tr>
    @endforeach
    <tr>
        <td colspan="8" style="height:12px;"></td>
    </tr>


    <tr>
        <td colspan="7" style="font-weight:bold;font-size:16px;background-color:#1A3C5E;color:#FFFFFF;padding:6px 8px;">
            📦 Vaccine Stocks
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Stock ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Hospital ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Vaccine ID</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Quantity</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Expiry Date</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Created At</td>
        <td style="font-weight:bold;background-color:#D9E8F5;border:1px solid #AAAAAA;">Total</td>
    </tr>
    @foreach ($VaccineStocks as $VaccineStock)
        <tr>
            <td style="border:1px solid #DDDDDD;">{{ $VaccineStock->id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccineStock->hospital_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccineStock->vaccine_id }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccineStock->quantity }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccineStock->expiry_date }}</td>
            <td style="border:1px solid #DDDDDD;">{{ $VaccineStock->created_at }}</td>
            @if ($loop->first)
                <td style="border:1px solid #DDDDDD;font-weight:bold;">{{ $VaccineStocks->count() }}</td>
            @else
                <td style="border:1px solid #DDDDDD;"></td>
            @endif
        </tr>
    @endforeach

</table>