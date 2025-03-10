<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function show($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($patient);
    }

    public function search(Request $request)
    {
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $middleName = $request->input('middle_name');
        $age = $request->input('age');

        $query = Patient::query();

        if ($firstName) {
            $query->where('first_name', $firstName); 
        }
        if ($lastName) {
            $query->where('last_name', $lastName); 
        }
        if ($middleName) {
            $query->where('middle_name', $middleName); 
        }
        if ($age) {
            $query->where('age', $age); 
        }

        $patients = $query->get();
        return response()->json($patients);


    }
}
