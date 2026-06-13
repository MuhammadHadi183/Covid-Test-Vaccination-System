<?php

namespace App\Actions\Fortify;

use App\Models\Hospital;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'role' => ['required', 'in:patient,hospital'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $Role = $input['role'] ?? 'patient';
        $Status = $Role === 'hospital' ? 'pending' : 'approved';

        $User = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $Role,
            'status' => $Status,
        ]);

        // Auto-create profile record
        if ($Role === 'patient') {
            Patient::create(['user_id' => $User->id]);
        } elseif ($Role === 'hospital') {
            Hospital::create([
                'user_id' => $User->id,
                'hospital_name' => $input['name'],
                'address' => 'N/A',
                'city' => 'N/A',
                'status' => 'pending',
            ]);
        }

        return $User;
    }
}
