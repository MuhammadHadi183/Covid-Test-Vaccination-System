<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\Vaccine;
use Illuminate\Http\Request;

class ResourceApiController extends Controller
{
    public function Show($Model)
    {
        switch ($Model) {
            case 'Users':
                return response()->json(User::all());
            case 'Patients':
                return response()->json(Patient::all());
            case 'Hospitals':
                return Hospital::with('vaccineStocks.vaccine')->get();
            case 'Vaccines':
                return Vaccine::all();
            case 'All':
                return response()->json([
                    'Users' => User::all(),
                    'Patients' => Patient::with('user')->get(),
                    'Hospitals' => Hospital::with('vaccineStocks.vaccine')->get(),
                    'Vaccines' => Vaccine::all()
                ]);
            default:
                return response()->json(['Error' => 'Model Not Found'], 404);
        }
    }
    public function Store(Request $Request, $Model)
    {

        switch ($Model) {
            case 'Users':
                $Data = User::create($Request->all());
                return response()->json(['Success' => 'User created successfully'], 200);
                break;
            case 'Patients':
                $Data = Patient::create($Request->all());
                return response()->json(['Success' => 'Patient created successfully'], 200);
                break;
            case 'Hospitals':
                $Data = Hospital::create($Request->all());
                return response()->json(['Success' => 'Hospital created successfully'], 200);
                break;
            case 'Vaccines':
                $Data = Vaccine::create($Request->all());
                return response()->json(['Success' => 'Vaccine created successfully'], 200);
                break;
            default:
                return response()->json(['Error' => 'Model Not Found'], 404);
        }
    }


    public function Update(Request $Request, $Model, $Id)
    {

        switch ($Model) {
            case 'Users':
                $Data = User::find($Id);
                $Data->update($Request->all());
                return response()->json(['Success' => 'User updated successfully'], 200);
                break;
            case 'Patients':
                $Data = Patient::find($Id);
                $Data->update($Request->all());
                return response()->json(['Success' => 'Patient updated successfully'], 200);
                break;
            case 'Hospitals':
                $Data = Hospital::find($Id);
                $Data->update($Request->all());
                return response()->json(['Success' => 'Hospital updated successfully'], 200);
                break;
            case 'Vaccines':
                $Data = Vaccine::find($Id);
                $Data->update($Request->all());
                return response()->json(['Success' => 'Vaccine updated successfully'], 200);
                break;
            default:
                return response()->json(['Error' => 'Model Not Found'], 404);
        }

    }




    public function Destroy($Model, $Id)
    {

        switch ($Model) {
            case 'Users':
                $Data = User::find($Id);
                $Data->delete();
                return response()->json(['Success' => 'User deleted successfully'], 200);
                break;
            case 'Patients':
                $Data = Patient::find($Id);
                $Data->delete();
                return response()->json(['Success' => 'Patient deleted successfully'], 200);
                break;
            case 'Hospitals':
                $Data = Hospital::find($Id);
                $Data->delete();
                return response()->json(['Success' => 'Hospital deleted successfully'], 200);
                break;
            case 'Vaccines':
                $Data = Vaccine::find($Id);
                $Data->delete();
                return response()->json(['Success' => 'Vaccine deleted successfully'], 200);
                break;
            default:
                return response()->json(['Error' => 'Model Not Found'], 404);
        }

    }

    
}