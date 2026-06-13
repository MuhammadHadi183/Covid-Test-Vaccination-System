<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\CovidTest;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\PatientRequest;
use App\Models\User;
use App\Models\Vaccine;
use App\Models\VaccinationRecord;
use App\Models\VaccineStock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin', 'email' => 'admin@covidvac.com',
            'password' => Hash::make('password'), 'role' => 'admin', 'status' => 'approved',
            'email_verified_at' => now(),
        ]);

        // Vaccines
        $Pfizer = Vaccine::create(['name' => 'Pfizer-BioNTech', 'manufacturer' => 'Pfizer', 'doses_required' => 2, 'status' => 'available']);
        $Sinovac = Vaccine::create(['name' => 'Sinovac CoronaVac', 'manufacturer' => 'Sinovac', 'doses_required' => 2, 'status' => 'available']);
        $Astra = Vaccine::create(['name' => 'AstraZeneca', 'manufacturer' => 'Oxford', 'doses_required' => 2, 'status' => 'available']);
        $CanSino = Vaccine::create(['name' => 'CanSino Bio', 'manufacturer' => 'CanSino', 'doses_required' => 1, 'status' => 'available']);
        $Moderna = Vaccine::create(['name' => 'Moderna', 'manufacturer' => 'Moderna', 'doses_required' => 2, 'status' => 'unavailable']);

        // Hospitals
        $HUser1 = User::create(['name' => 'City General Hospital', 'email' => 'city@hospital.com', 'password' => Hash::make('password'), 'role' => 'hospital', 'status' => 'approved', 'city' => 'Karachi', 'email_verified_at' => now()]);
        $H1 = Hospital::create(['user_id' => $HUser1->id, 'hospital_name' => 'City General Hospital', 'registration_no' => 'HRG-001', 'address' => 'Block 4, Clifton', 'city' => 'Karachi', 'phone' => '021-1234567', 'status' => 'approved', 'profile_completed' => true]);

        $HUser2 = User::create(['name' => 'NICVD Karachi', 'email' => 'nicvd@hospital.com', 'password' => Hash::make('password'), 'role' => 'hospital', 'status' => 'approved', 'city' => 'Karachi', 'email_verified_at' => now()]);
        $H2 = Hospital::create(['user_id' => $HUser2->id, 'hospital_name' => 'NICVD Karachi', 'registration_no' => 'HRG-002', 'address' => 'Suparco Road', 'city' => 'Karachi', 'phone' => '021-9876543', 'status' => 'approved', 'profile_completed' => true]);

        $HUser3 = User::create(['name' => 'Lahore General', 'email' => 'lahore@hospital.com', 'password' => Hash::make('password'), 'role' => 'hospital', 'status' => 'pending', 'city' => 'Lahore', 'email_verified_at' => now()]);
        $H3 = Hospital::create(['user_id' => $HUser3->id, 'hospital_name' => 'Lahore General Hospital', 'registration_no' => 'HRG-003', 'address' => 'Ferozepur Road', 'city' => 'Lahore', 'phone' => '042-1112233', 'status' => 'pending', 'profile_completed' => false]);

        // Stocks
        VaccineStock::create(['hospital_id' => $H1->id, 'vaccine_id' => $Pfizer->id, 'quantity' => 2148, 'expiry_date' => '2025-06-30']);
        VaccineStock::create(['hospital_id' => $H1->id, 'vaccine_id' => $Sinovac->id, 'quantity' => 3500, 'expiry_date' => '2025-08-15']);
        VaccineStock::create(['hospital_id' => $H1->id, 'vaccine_id' => $Astra->id, 'quantity' => 187, 'expiry_date' => '2025-07-20']);
        VaccineStock::create(['hospital_id' => $H2->id, 'vaccine_id' => $Pfizer->id, 'quantity' => 1200, 'expiry_date' => '2025-09-01']);
        VaccineStock::create(['hospital_id' => $H2->id, 'vaccine_id' => $CanSino->id, 'quantity' => 490, 'expiry_date' => '2025-07-15']);

        // Patients
        $Names = ['Ahmad Saeed','Fatima Malik','Zubair Khan','Nadia Hussain','Imran Qureshi','Sara Ali','Hina Bashir','Bilal Akhtar','Maryam Tahir','Junaid Mirza'];
        $Genders = ['male','female','male','female','male','female','female','male','female','male'];

    


           
        }
    }
